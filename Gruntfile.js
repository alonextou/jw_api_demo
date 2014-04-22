module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			sass: {
				files: 'public/scss/**/*.scss',
				tasks: ['compass:dev']
			},
			neuter: {
				files: 'public/js/app/**/*.js',
				tasks: ['neuter']
			}
		},
		compass: {
			dev: {
				options: {
					config: 'public/config.rb'
				}
			},
			dist: {
				options: {
					config: 'public/config.rb',
					outputStyle: 'compressed'
				}
			}
		},
		neuter: {
			dev: {
				options: {
					filepathTransform: function (filepath) {
						return 'js/' + filepath;
					}
				},
				src: 'public/js/app/init.js',
				dest: 'public/js/dist/global.js'
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-neuter');
	grunt.loadNpmTasks('grunt-usemin');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-htmlmin');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-rev');

	grunt.registerTask('default', ['compass:dist', 'neuter:dev']);

}