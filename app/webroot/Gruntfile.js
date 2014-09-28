module.exports = function(grunt) {

	var jsFiles = [
		'js/src/namespace.js',
		'js/src/Delegator.js',
		'js/src/Movements.js',
		'js/src/FormMovement.js',
		'js/src/Main.js'
	];

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			options: {
				stripBanners: true,
				banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */'
			},
			dist: {
				src: jsFiles,
				dest: 'js/script.min.js'
			}
		},
		uglify: {
			dev: {
				options: {
					banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
				},
				files: {
					'js/script.min.js': [jsFiles]
				}
			}
		},
		stylus: {
			dev: {
				options: {
					paths: ['./css/stylus'],
					compress: false,
					use: [require('nib')]
				},
				files: {
					'./css/styles.css': './css/stylus/styles.styl'
				}
			}
		},
		watch: {
			css: {
				files: ['css/stylus/**/*.styl'],
				tasks: ['stylus'],
				options: {
					livereload: true
				}
			},
			js: {
				files: ['js/src/**/*.js'],
				tasks: ['concat'],
				options: {
					livereload: true
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-stylus');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default', ['concat', 'stylus', 'watch']);

}