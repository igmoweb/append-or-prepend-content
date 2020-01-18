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
        exclude: [ 'node_modules/*', 'vendor/*', 'tests/*', 'build/*', 'svn/*' ]
			},
			dist: {
				options: {
					potFilename: 'apporprepp.pot',
				},
			},
		},

		"regex-replace": {
			placeholders: { //specify a target with any name
				src: [
					'./build/readme.txt',
					'./build/app-prep-content.php',
				],
				actions: [
					{
						name: 'version',
						search: '%%version%%',
						replace: '<%= pkg.version %>',
						flags: 'g'
					},{
						name: 'testedupto',
						search: '%%testedupto%%',
						replace: '<%= pkg.testedupto %>',
						flags: 'g'
					},{
						name: 'requires',
						search: '%%requires%%',
						replace: '<%= pkg.requires %>',
						flags: 'g'
					}
				]
			}
		},

		shell: {
			command: 'svn co https://plugins.svn.wordpress.org/append-or-prepend-content svn'
		},

		copy: {
			main: {
				files: [
					{
						expand: true,
						src: [
							'**/**.*',
							'!phpunit.xml.dist',
							'!tests/**/*',
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
			svn: {
				files: [
					{
						expand: true,
						src: [
							'**/*.*'
						],
						dest: 'svn/trunk/',
						cwd: 'build/'
					},
					{
						expand: true,
						src: [
							'**/*.*'
						],
						dest: 'svn/tags/<%= pkg.version %>',
						cwd: 'build/'
					},
					{
						expand: true,
						src: [
							'**/*.*'
						],
						dest: 'svn/assets/',
						cwd: 'assets-wporg/'
					}
				]
			}
		},
		clean: {
			build: [
				'build'
			],
			svn: [
				'svn/tags/<%= pkg.version %>',
				'svn/trunk/',
				'svn/assets/'
			],
		}
	} );

	grunt.registerTask( 'default', [
		'checktextdomain',
		'makepot',
		'clean:build',
		'copy',
		'regex-replace:placeholders',
		'shell',
		'clean:svn',
		'copy:svn'
	] );

	grunt.registerTask( 'dopot', 'makepot' );
}
