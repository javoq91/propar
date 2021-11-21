# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|


  # The project name is base for directories, hostname and alike
  project_name = "propar"

  config.vm.box = "scotch/box"
  config.vm.network "private_network", ip: "192.168.33.11"
  config.vm.hostname = "propar"
  config.vm.synced_folder ".", "/var/www", :mount_options => ["dmode=777", "fmode=666"]

  config.hostmanager.enabled = false
  config.hostmanager.manage_host = true
  config.hostmanager.ignore_private_ip = false
  config.hostmanager.include_offline = true
  config.hostmanager.aliases = [ "www." + project_name + ".local" ]

	# hostmanager provisioner
	config.vm.provision :hostmanager

end
