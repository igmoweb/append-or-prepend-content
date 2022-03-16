module.exports = function (grunt) {
	require('load-grunt-tasks')(grunt);
	grunt.loadNpmTasks('grunt-contrib-copy');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		'regex-replace': {
			placeholders: {
				//specify a target with any name
				src: [
					'./build-wporg/readme.txt',
					'./build-wporg/app-prep-content.php',
				],
				actions: [
					{
						name: 'version',
						search: '%%version%%',
						replace: '<%= pkg.version %>',
						flags: 'g',
					},
					{
						name: 'testedupto',
						search: '%%testedupto%%',
						replace: '<%= pkg.testedupto %>',
						flags: 'g',
					},
					{
						name: 'requires',
						search: '%%requires%%',
						replace: '<%= pkg.requires %>',
						flags: 'g',
					},
					{
						name: 'requires_php',
						search: '%%requires_php%%',
						replace: '<%= pkg.requires_php %>',
						flags: 'g',
					},
				],
			},
		},

		shell: {
			command:
				'svn co https://plugins.svn.wordpress.org/append-or-prepend-content svn',
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
							'!docker-compose.yml',
							'!bin/**/*',
							'!composer.*',
							'!package.*',
							'!package-lock*',
							'!phpcs.xml',
							'!Gruntfile.js',
							'!build-wporg/**/*',
							'!svn/**/*',
							'!assets-wporg/**/*',
							'!README.md',
						],
						dest: 'build-wporg/',
					},
				],
			},
			svn: {
				files: [
					{
						expand: true,
						src: ['**/*.*'],
						dest: 'svn/trunk/',
						cwd: 'build-wporg/',
					},
					{
						expand: true,
						src: ['**/*.*'],
						dest: 'svn/tags/<%= pkg.version %>',
						cwd: 'build-wporg/',
					},
					{
						expand: true,
						src: ['**/*.*'],
						dest: 'svn/assets/',
						cwd: 'assets-wporg/',
					},
				],
			},
		},
		clean: {
			build: ['build-wporg'],
			svn: ['svn/tags/<%= pkg.version %>', 'svn/trunk/', 'svn/assets/'],
		},
	});

	grunt.registerTask('default', [
		'clean:build',
		'copy',
		'regex-replace:placeholders',
		'shell',
		'clean:svn',
		'copy:svn',
	]);
};
