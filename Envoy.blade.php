{{-- Define all our servers --}}
@servers(['local' => '127.0.0.1','alpha' => 'intangiblealphaproparluis@alpha.propar.intangible.com.py','beta' => 'intangiblebetaproparluis@beta.propar.intangible.com.py'])

@setup

	$timezone = 'America/Asuncion';

	$destination = $on;

	$server = [
		'local' => '',
		'production' => 'propar.com.py',
		'stage' => 'propar.com.py',
		'beta' => 'beta.propar.intangible.com.py',
		'alpha' => 'alpha.propar.intangible.com.py'
	];

	$chownuser = [
		'alpha' => 'intangiblealphaproparluis',
		'beta' => 'intangiblebetaproparluis'
	];

	$chowngroup = [
		'alpha' => 'client1',
		'beta' => 'client1'
	];

	$path = [
		'alpha' => '/web',
		'beta' => '/web'
	];

	$symlinkpath = [
		'alpha' => '/var/www/alpha.propar.intangible.com.py',
		'beta' => '/var/www/beta.propar.intangible.com.py'
	];

	$envfile = [
		'production' => '.env.php',
		'stage' => '.env.stage.php',
		'alpha' => '.env.alpha.php',
		'beta' => '.env.beta.php'
	];

	$repo = 'git@gitlab.intangible.com.py:EmilioBravo/propar-com-py.git';

	$branch = (!empty($branch))? $branch : 'master';

	$keep = 1 + 1;

	$hasHtmlPurifier = false;

	$chmods = [
		'app/storage',
		'public',
		'app/storage/meta/'
	];

	$symlinks = [
		'storage/views'    => 'app/storage/views',
		'storage/sessions' => 'app/storage/sessions',
		'storage/logs'     => 'app/storage/logs',
		'storage/cache'    => 'app/storage/cache',
		'public/uploads'    => 'public/uploads',
	];

	$date    = new DateTime('now', new DateTimeZone($timezone));
	if(isset($release)){
		$release_path = $path[$on] .'/releases/'. $release;
	}else{
		$release = $date->format('YmdHis');
		$release_path = $path[$on] .'/releases/'. $release;
	}
	error_log("Processing release: " . $release);
@endsetup

@task('copy-env-files',['on' => 'local'])

	scp {{ $envfile[$destination] }} {{ $chownuser[$destination] }}""@""{{ $server[$destination] }}:{{ $release_path }}/{{ $envfile[$destination] }}

@endtask

@task('clone', ['on' => $on])
	mkdir -p {{ $release_path }}

	git clone --depth 1 -b {{ $branch }} "{{ $repo }}" {{ $release_path }}

	echo "Repository has been cloned"
@endtask

@task('composer', ['on' => $on])
	{{-- composer self-update --}}

	cd {{ $release_path }}

	composer install --no-interaction --no-dev --prefer-source

	echo "Composer dependencies have been installed"
@endtask

{{-- Symlink some folders --}}
@task('symlinks', ['on' => $on])
	@foreach($symlinks as $folder => $symlink)

		echo "ln -s -f {{ $symlinkpath[$on] }}{{ $path[$on] }}/shared/{{ $folder }} {{ $symlinkpath[$on] }}{{ $release_path }}/{{ $symlink }}"

		rm -Rf {{ $symlinkpath[$on] }}{{ $release_path }}/{{ $symlink }}

		ln -s -f {{ $symlinkpath[$on] }}{{ $path[$on] }}/shared/{{ $folder }} {{ $symlinkpath[$on] }}{{ $release_path }}/{{ $symlink }}

		echo "Symlink has been set for {{ $symlink }}"

	@endforeach

	echo "All symlinks have been set"

	ls -lha {{ $symlinkpath[$on] }}{{ $release_path }}/app/storage

@endtask

{{-- Set permissions for various files and directories --}}
@task('chmod', ['on' => $on])
	@foreach($chmods as $file)
		chmod -R 775 {{ $release_path }}/{{ $file }}

		chmod -R g+s {{ $release_path }}/{{ $file }}

		chown -R {{ $chownuser[$on] }}:{{ $chowngroup[$on] }} {{ $release_path }}/{{ $file }}

		echo "Permissions have been set for {{ $file }}"
	@endforeach

	@if($hasHtmlPurifier)
		chmod -R 777 {{ $release_path }}/vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer
		echo "Permissions for HTMLPurifier have been set"
	@endif
@endtask

{{-- Migrate all databases --}}
@task('migrate',['on' => $on])

	export ENVIRONMENT="{{ $on }}"

	php {{ $release_path }}/artisan migrate

	php {{ $release_path }}/artisan db:seed --class="EmilioBravo\Platform\DatabaseSeeder"

	php {{ $release_path }}/artisan migrate --package=emilio-bravo/pages

	php {{ $release_path }}/artisan migrate --package=emilio-bravo/contacts

	php {{ $release_path }}/artisan migrate --package=emilio-bravo/sauna

	php {{ $release_path }}/artisan db:seed --class="EmilioBravo\Sauna\DatabaseSeeder"

	php {{ $release_path }}/artisan migrate --package=emilio-bravo/blog

@endtask

{{-- Set the symlink for the current release --}}
@task('update-symlink', ['on' => $on])
	rm -rf {{ $path[$on] }}/current

	ln -s {{ $symlinkpath[$on] }}{{ $release_path }} {{ $symlinkpath[$on] }}/web/current

	echo "Release symlink has been set"
@endtask

{{-- Clean old releases --}}

@task('clean-old-releases',['on' => $on])

	cd {{ $path[$on] }}/releases/

	ls -1 -t |tail -n +{{$keep}} |xargs -I '{}' rm -Rf '{}'

@endtask

{{-- Just a donedeploy message :) --}}
@task('donedeploy', ['on' => $on])
	
	echo "Deployment finished."
	echo "Run the following command to update the symlinks"
	echo "envoy run update-symlink-macro --on={{ $on }} --release={{ $release }} ";

@endtask

{{-- Just a doneupdatesymlink message :) --}}
@task('doneupdatesymlink', ['on' => $on])

	echo "Run the following command to clean old releases";
	echo "envoy run clean-old-releases-macro --on={{ $on }} --release={{ $release }} ";

@endtask

{{-- Clear application cache --}}
@task('cache-clear', ['on' => $on])

	php {{ $path[$on] }}/current/artisan cache:clear
	echo "Cache cleared!"

@endtask

@task('ls',['on' => $on])

ls -la

@endtask

@task('test',['on' => $on])
	export ENVIRONMENT="{{ $on }}"
	echo "Release: {{ $release }}"
	php {{ $release }}/artisan env

@endtask

@task('backupdb',['on' => $on])

	php /web/current/artisan scheduled:run --debug --env=alpha

@endtask


{{-- Run all deployment tasks --}}
@macro('deploy')
	clone
	copy-env-files
	composer
	symlinks
	chmod
	donedeploy
@endmacro

{{-- Run all deployment tasks --}}
@macro('deployandmigrate')
	clone
	copy-env-files
	composer
	symlinks
	chmod
	migrate
	update-symlink
	clean-old-releases
	donedeploy
@endmacro

@macro('update-symlink-macro')
	update-symlink
	doneupdatesymlink
@endmacro

@macro('clean-old-releases-macro')
	clean-old-releases
@endmacro
