(function() {
    'use strict';

    /**
     * getSlug
     * @param   {string} input input string
     * @param   {object|string} opts config object or separator string/char
     * @api     public
     * @return  {string}  sluggified string
     */
    var getSlug = function getSlug(input, opts) {

        var maintainCase = (typeof opts === 'object' && opts.maintainCase) || false;
        var titleCase = (typeof opts === 'object' && opts.titleCase) ? opts.titleCase : false;
        var customReplacements = (typeof opts === 'object' && typeof opts.custom === 'object' && opts.custom) ? opts.custom : {};
        var separator = (typeof opts === 'object' && opts.separator) || '-';
        var truncate = (typeof opts === 'object' && +opts.truncate > 1 && opts.truncate) || false;
        var uricFlag = (typeof opts === 'object' && opts.uric) || false;
        var uricNoSlashFlag = (typeof opts === 'object' && opts.uricNoSlash) || false;
        var markFlag = (typeof opts === 'object' && opts.mark) || false;
        var symbol = (typeof opts === 'object' && opts.lang && symbolMap[opts.lang]) ? symbolMap[opts.lang] : (typeof opts === 'object' && (opts.lang === false || opts.lang === true) ? {} : symbolMap.en);
        var uricChars = [';', '?', ':', '@', '&', '=', '+', '$', ',', '/'];
        var uricNoSlashChars = [';', '?', ':', '@', '&', '=', '+', '$', ','];
        var markChars = ['.', '!', '~', '*', '\'', '(', ')'];
        var result = '';
        var lucky;
        var allowedChars = separator;
        var i;
        var ch;
        var l;
        var lastCharWasSymbol;

        if (titleCase && typeof titleCase.length === "number" && Array.prototype.toString.call(titleCase)) {

            // custom config is an Array, rewrite to object format
            titleCase.forEach(function(v) {
                customReplacements[v + ""] = v + "";
            });
        }

        if (typeof input !== 'string') {
            return '';
        }

        if (typeof opts === 'string') {
            separator = opts;
        } else if (typeof opts === 'object') {

            if (uricFlag) {
                allowedChars += uricChars.join('');
            }

            if (uricNoSlashFlag) {
                allowedChars += uricNoSlashChars.join('');
            }

            if (markFlag) {
                allowedChars += markChars.join('');
            }
        }

        // custom replacements
        Object.keys(customReplacements).forEach(function(v) {

            var r;

            if (v.length > 1) {
                r = new RegExp('\\b' + escapeChars(v) + '\\b', 'gi');
            } else {
                r = new RegExp(escapeChars(v), 'gi');
            }

            input = input.replace(r, customReplacements[v]);
        });

        if (titleCase) {
            input = input.replace(/(\w)(\S*)/g, function(_, i, r) {
                var j = i.toUpperCase() + (r !== null ? r : "");
                return (Object.keys(customReplacements).indexOf(j.toLowerCase()) < 0) ? j : j.toLowerCase();
            });
        }

        // escape all necessary chars
        allowedChars = escapeChars(allowedChars);

        // trim whitespaces
        input = input.replace(/(^\s+|\s+$)/g, '');

        lastCharWasSymbol = false;
        for (i = 0, l = input.length; i < l; i++) {

            ch = input[i];

            if (charMap[ch]) {

                // process diactrics chars
                ch = lastCharWasSymbol && charMap[ch].match(/[A-Za-z0-9]/) ? ' ' + charMap[ch] : charMap[ch];

                lastCharWasSymbol = false;
            } else if (

                // process symbol chars
                symbol[ch] && !(uricFlag && uricChars.join('').indexOf(ch) !== -1) && !(uricNoSlashFlag && uricNoSlashChars.join('').indexOf(ch) !== -1) && !(markFlag && markChars.join('').indexOf(ch) !== -1)) {

                ch = lastCharWasSymbol || result.substr(-1).match(/[A-Za-z0-9]/) ? separator + symbol[ch] : symbol[ch];
                ch += input[i + 1] !== void 0 && input[i + 1].match(/[A-Za-z0-9]/) ? separator : '';

                lastCharWasSymbol = true;
            } else {

                // process latin chars
                if (lastCharWasSymbol && (/[A-Za-z0-9]/.test(ch) || result.substr(-1).match(/A-Za-z0-9]/))) {
                    ch = ' ' + ch;
                }
                lastCharWasSymbol = false;
            }

            // add allowed chars
            result += ch.replace(new RegExp('[^\\w\\s' + allowedChars + '_-]', 'g'), separator);
        }

        // eliminate duplicate separators
        // add separator
        // trim separators from start and end
        result = result.replace(/\s+/g, separator)
            .replace(new RegExp('\\' + separator + '+', 'g'), separator)
            .replace(new RegExp('(^\\' + separator + '+|\\' + separator + '+$)', 'g'), '');

        if (truncate && result.length > truncate) {

            lucky = result.charAt(truncate) === separator;
            result = result.slice(0, truncate);

            if (!lucky) {
                result = result.slice(0, result.lastIndexOf(separator));
            }
        }

        if (!maintainCase && !titleCase && !titleCase.length) {
            result = result.toLowerCase();
        }

        return result;
    };

    /**
     * createSlug curried(opts)(input)
     * @param   {object|string} opts config object or input string
     * @return  {Function} function getSlugWithConfig()
     **/
    var createSlug = function createSlug(opts) {

        /**
         * getSlugWithConfig
         * @param   {string} input string
         * @return  {string} slug string
         */
        return function getSlugWithConfig(input) {
            return getSlug(input, opts);
        };
    };

    var escapeChars = function escapeChars(input) {
        return input.replace(/[-\\^$*+?.()|[\]{}\/]/g, '\\$&');
    };

    /**
     * charMap
     * @type {Object}
     */
    var charMap = {
        // latin
        '??': 'A',
        '??': 'A',
        '??': 'A',
        '??': 'A',
        '??': 'Ae',
        '??': 'A',
        '??': 'AE',
        '??': 'C',
        '??': 'E',
        '??': 'E',
        '??': 'E',
        '??': 'E',
        '??': 'I',
        '??': 'I',
        '??': 'I',
        '??': 'I',
        '??': 'D',
        '??': 'N',
        '??': 'O',
        '??': 'O',
        '??': 'O',
        '??': 'O',
        '??': 'Oe',
        '??': 'O',
        '??': 'O',
        '??': 'U',
        '??': 'U',
        '??': 'U',
        '??': 'Ue',
        '??': 'U',
        '??': 'Y',
        '??': 'TH',
        '??': 'ss',
        '??': 'a',
        '??': 'a',
        '??': 'a',
        '??': 'a',
        '??': 'ae',
        '??': 'a',
        '??': 'ae',
        '??': 'c',
        '??': 'e',
        '??': 'e',
        '??': 'e',
        '??': 'e',
        '??': 'i',
        '??': 'i',
        '??': 'i',
        '??': 'i',
        '??': 'd',
        '??': 'n',
        '??': 'o',
        '??': 'o',
        '??': 'o',
        '??': 'o',
        '??': 'oe',
        '??': 'o',
        '??': 'o',
        '??': 'u',
        '??': 'u',
        '??': 'u',
        '??': 'ue',
        '??': 'u',
        '??': 'y',
        '??': 'th',
        '??': 'y',
        '???': 'SS',
        // greek
        '??': 'a',
        '??': 'b',
        '??': 'g',
        '??': 'd',
        '??': 'e',
        '??': 'z',
        '??': 'h',
        '??': '8',
        '??': 'i',
        '??': 'k',
        '??': 'l',
        '??': 'm',
        '??': 'n',
        '??': '3',
        '??': 'o',
        '??': 'p',
        '??': 'r',
        '??': 's',
        '??': 't',
        '??': 'y',
        '??': 'f',
        '??': 'x',
        '??': 'ps',
        '??': 'w',
        '??': 'a',
        '??': 'e',
        '??': 'i',
        '??': 'o',
        '??': 'y',
        '??': 'h',
        '??': 'w',
        '??': 's',
        '??': 'i',
        '??': 'y',
        '??': 'y',
        '??': 'i',
        '??': 'A',
        '??': 'B',
        '??': 'G',
        '??': 'D',
        '??': 'E',
        '??': 'Z',
        '??': 'H',
        '??': '8',
        '??': 'I',
        '??': 'K',
        '??': 'L',
        '??': 'M',
        '??': 'N',
        '??': '3',
        '??': 'O',
        '??': 'P',
        '??': 'R',
        '??': 'S',
        '??': 'T',
        '??': 'Y',
        '??': 'F',
        '??': 'X',
        '??': 'PS',
        '??': 'W',
        '??': 'A',
        '??': 'E',
        '??': 'I',
        '??': 'O',
        '??': 'Y',
        '??': 'H',
        '??': 'W',
        '??': 'I',
        '??': 'Y',
        // turkish
        '??': 's',
        '??': 'S',
        '??': 'i',
        '??': 'I',
        // '??': 'c', // duplicate
        // '??': 'C', // duplicate
        // '??': 'ue', // duplicate
        // '??': 'Ue', // duplicate
        // '??': 'oe', // duplicate
        // '??': 'Oe', // duplicate
        '??': 'g',
        '??': 'G',
        // macedonian
        '??': 'Kj',
        '??': 'kj',
        '??': 'Lj',
        '??': 'lj',
        '??': 'Nj',
        '??': 'nj',
        '????': 'Ts',
        '????': 'ts',
        // russian
        '??': 'a',
        '??': 'b',
        '??': 'v',
        '??': 'g',
        '??': 'd',
        '??': 'e',
        '??': 'yo',
        '??': 'zh',
        '??': 'z',
        '??': 'i',
        '??': 'j',
        '??': 'k',
        '??': 'l',
        '??': 'm',
        '??': 'n',
        '??': 'o',
        '??': 'p',
        '??': 'r',
        '??': 's',
        '??': 't',
        '??': 'u',
        '??': 'f',
        '??': 'h',
        '??': 'c',
        '??': 'ch',
        '??': 'sh',
        '??': 'sh',
        '??': '',
        '??': 'y',
        '??': '',
        '??': 'e',
        '??': 'yu',
        '??': 'ya',
        '??': 'A',
        '??': 'B',
        '??': 'V',
        '??': 'G',
        '??': 'D',
        '??': 'E',
        '??': 'Yo',
        '??': 'Zh',
        '??': 'Z',
        '??': 'I',
        '??': 'J',
        '??': 'K',
        '??': 'L',
        '??': 'M',
        '??': 'N',
        '??': 'O',
        '??': 'P',
        '??': 'R',
        '??': 'S',
        '??': 'T',
        '??': 'U',
        '??': 'F',
        '??': 'H',
        '??': 'C',
        '??': 'Ch',
        '??': 'Sh',
        '??': 'Sh',
        '??': '',
        '??': 'Y',
        '??': '',
        '??': 'E',
        '??': 'Yu',
        '??': 'Ya',
        // ukranian
        '??': 'Ye',
        '??': 'I',
        '??': 'Yi',
        '??': 'G',
        '??': 'ye',
        '??': 'i',
        '??': 'yi',
        '??': 'g',
        // czech
        '??': 'c',
        '??': 'd',
        '??': 'e',
        '??': 'n',
        '??': 'r',
        '??': 's',
        '??': 't',
        '??': 'u',
        '??': 'z',
        '??': 'C',
        '??': 'D',
        '??': 'E',
        '??': 'N',
        '??': 'R',
        '??': 'S',
        '??': 'T',
        '??': 'U',
        '??': 'Z',
        // polish
        '??': 'a',
        '??': 'c',
        '??': 'e',
        '??': 'l',
        '??': 'n',
        // '??': 'o', // duplicate
        '??': 's',
        '??': 'z',
        '??': 'z',
        '??': 'A',
        '??': 'C',
        '??': 'E',
        '??': 'L',
        '??': 'N',
        '??': 'S',
        '??': 'Z',
        '??': 'Z',
        // latvian
        '??': 'a',
        // '??': 'c', // duplicate
        '??': 'e',
        '??': 'g',
        '??': 'i',
        '??': 'k',
        '??': 'l',
        '??': 'n',
        // '??': 's', // duplicate
        '??': 'u',
        // '??': 'z', // duplicate
        '??': 'A',
        // '??': 'C', // duplicate
        '??': 'E',
        '??': 'G',
        '??': 'I',
        '??': 'k',
        '??': 'L',
        '??': 'N',
        // '??': 'S', // duplicate
        '??': 'U',
        // '??': 'Z', // duplicate
        // Arabic
        '??': 'a',
        '??': 'a',
        '??': 'i',
        '??': 'aa',
        '??': 'u',
        '??': 'e',
        '??': 'a',
        '??': 'b',
        '??': 't',
        '??': 'th',
        '??': 'j',
        '??': 'h',
        '??': 'kh',
        '??': 'd',
        '??': 'th',
        '??': 'r',
        '??': 'z',
        '??': 's',
        '??': 'sh',
        '??': 's',
        '??': 'dh',
        '??': 't',
        '??': 'z',
        '??': 'a',
        '??': 'gh',
        '??': 'f',
        '??': 'q',
        '??': 'k',
        '??': 'l',
        '??': 'm',
        '??': 'n',
        '??': 'h',
        '??': 'w',
        '??': 'y',
        '??': 'a',
        '??': 'h',
        '???': 'la',
        '???': 'laa',
        '???': 'lai',
        '???': 'laa',
        // Arabic diactrics
        '??': 'a',
        '??': 'an',
        '??': 'e',
        '??': 'en',
        '??': 'u',
        '??': 'on',
        '??': '',

        // Arabic numbers
        '??': '0',
        '??': '1',
        '??': '2',
        '??': '3',
        '??': '4',
        '??': '5',
        '??': '6',
        '??': '7',
        '??': '8',
        '??': '9',
        // symbols
        '???': '"',
        '???': '"',
        '???': '\'',
        '???': '\'',
        '???': 'd',
        '??': 'f',
        '???': '(TM)',
        '??': '(C)',
        '??': 'oe',
        '??': 'OE',
        '??': '(R)',
        '???': '+',
        '???': '(SM)',
        '???': '...',
        '??': 'o',
        '??': 'o',
        '??': 'a',
        '???': '*',
        // currency
        '$': 'USD',
        '???': 'EUR',
        '???': 'BRN',
        '???': 'FRF',
        '??': 'GBP',
        '???': 'ITL',
        '???': 'NGN',
        '???': 'ESP',
        '???': 'KRW',
        '???': 'ILS',
        '???': 'VND',
        '???': 'LAK',
        '???': 'MNT',
        '???': 'GRD',
        '???': 'ARS',
        '???': 'PYG',
        '???': 'ARA',
        '???': 'UAH',
        '???': 'GHS',
        '??': 'cent',
        '??': 'CNY',
        '???': 'CNY',
        '???': 'YEN',
        '???': 'IRR',
        '???': 'EWE',
        '???': 'THB',
        '???': 'INR',
        '???': 'INR',
        '???': 'PF'
    };

    /**
     * symbolMap language specific symbol translations
     * @type   {Object}
     */
    var symbolMap = {

        'ar': {
            '???': 'delta',
            '???': 'la-nihaya',
            '???': 'hob',
            '&': 'wa',
            '|': 'aw',
            '<': 'aqal-men',
            '>': 'akbar-men',
            '???': 'majmou',
            '??': 'omla'
        },

        'de': {
            '???': 'delta',
            '???': 'unendlich',
            '???': 'Liebe',
            '&': 'und',
            '|': 'oder',
            '<': 'kleiner als',
            '>': 'groesser als',
            '???': 'Summe von',
            '??': 'Waehrung'
        },

        'nl': {
            '???': 'delta',
            '???': 'oneindig',
            '???': 'liefde',
            '&': 'en',
            '|': 'of',
            '<': 'kleiner dan',
            '>': 'groter dan',
            '???': 'som',
            '??': 'valuta'
        },

        'en': {
            '???': 'delta',
            '???': 'infinity',
            '???': 'love',
            '&': 'and',
            '|': 'or',
            '<': 'less than',
            '>': 'greater than',
            '???': 'sum',
            '??': 'currency'
        },

        'es': {
            '???': 'delta',
            '???': 'infinito',
            '???': 'amor',
            '&': 'y',
            '|': 'u',
            '<': 'menos que',
            '>': 'mas que',
            '???': 'suma de los',
            '??': 'moneda'
        },

        'fr': {
            '???': 'delta',
            '???': 'infiniment',
            '???': 'Amour',
            '&': 'et',
            '|': 'ou',
            '<': 'moins que',
            '>': 'superieure a',
            '???': 'somme des',
            '??': 'monnaie'
        },

        'pt': {
            '???': 'delta',
            '???': 'infinito',
            '???': 'amor',
            '&': 'e',
            '|': 'ou',
            '<': 'menor que',
            '>': 'maior que',
            '???': 'soma',
            '??': 'moeda'
        },

        'ru': {
            '???': 'delta',
            '???': 'beskonechno',
            '???': 'lubov',
            '&': 'i',
            '|': 'ili',
            '<': 'menshe',
            '>': 'bolshe',
            '???': 'summa',
            '??': 'valjuta'
        }
    };

    if (typeof module !== 'undefined' && module.exports) {

        // export functions for use in Node
        module.exports = getSlug;
        module.exports.createSlug = createSlug;

    } else if (typeof define !== 'undefined' && define.amd) {

        // export function for use in AMD
        define([], function() {
            return getSlug;
        });

    } else {
        // don't overwrite global if exists
        try {
            if (window.getSlug || window.createSlug) {
                throw 'speakingurl: globals exists /(getSlug|createSlug)/';
            } else {
                window.getSlug = getSlug;
                window.createSlug = createSlug;
            }
        } catch (e) {}

    }
})();
