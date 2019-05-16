module.exports = function( grunt ) {
	require( 'load-grunt-tasks' )( grunt );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON('package.json'),
		checktextdomain: {

			options: {
				report_missing: false,
				text_domain: 'apporprepp',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d',
				],
			},
			files: {
				src: [
					'./**/*.php', // Include all files
					'!./vendor/**/*',
					'!./node_modules/**/*',
					'!./svn/**/*',
					'!./assets-wporg/**/*',
					'!./build/**/*',
				],
				expand: true,
			},
		},
		// Generate POT files.
		makepot: {
			options: {
				type: 'wp-plugin',
				domainPath: 'languages',
			},
			dist: {
				options: {
					potFilename: 'apporprepp.pot',
				},
			},
		},

		search: {
			files: {
				src: ['<%= pkg.main %>']
			},
			options: {
				logFile: '/tmp/log-search.log',
				searchString: /^[ \t\/*#@]*Version:(.*)$/mig,
				onMatch: function(match) {
					var regExp = /^[ \t\/*#@]*Version:(.*)$/mig;
					var groupedMatches = regExp.exec( match.match );
					var versionFound = groupedMatches[1].trim();
					if ( versionFound !== grunt.file.readJSON('package.json').version ) {
						grunt.fail.fatal("Plugin version does not match with package.json version. Please, fix.");
					}
				},
				onComplete: function( matches ) {
					if ( ! matches.numMatches ) {
						if ( ! grunt.file.readJSON('package.json').main ) {
							grunt.fail.fatal("main field is not defined in package.json. Please, add the plugin main file on that field.");
						}
						else {
							grunt.fail.fatal("Version Plugin header not found in " + grunt.file.readJSON('package.json').main + " file or the file does not exist" );
						}
					}
				}
			}
		},

		shell: {
			command: './bin/build.sh <%= pkg.version %>'
		},

		copy: {
			main: {
				files: [
					{
						expand: true,
						src: [
							'**/**.*',
							'!.gitignore',
							'!node_modules/**/*',
							'!vendor/**/*',
							'!bin/**/*',
							'!composer.*',
							'!package.*',
							'!package-lock*',
							'!phpcs.xml',
							'!Gruntfile.js',
							'!build/**/*',
							'!svn/**/*',
							'!assets-wporg/**/*',
						],
						dest: 'build/',
					},
				],
			},
		},
	} );

	grunt.registerTask( 'default', [ 'checktextdomain', 'makepot', 'copy', 'shell' ] );
	grunt.registerTask( 'version-compare', [ 'search' ] );
}
