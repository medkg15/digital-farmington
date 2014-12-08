module.exports = function(grunt) {
  grunt.initConfig({
	requirejs: {
		development: {
			options: {
				mainConfigFile: 'src/public/js/common.js',
				baseUrl:'.',
				appDir: 'src/public/js',
				dir: 'src/public/js-built',
				optimize: 'none',
				modules: [
					{
						name: 'common',
						include: ['jquery', 'bootstrap', 'underscore']
					}/*,
					{
						name: 'app/gameViewModel',
						exclude: ['common']
					}*/
				]
			}
		},
		production: {
			options: {
				mainConfigFile: 'src/public/js/common.js',
				baseUrl:'.',
				appDir: 'src/public/js',
				dir: 'src/public/js-built',
				optimize: 'uglify',
				modules: [ 
					{
						name: 'common',
						include: ['jquery', 'bootstrap', 'underscore']
					}/*,
					{
						name: 'app/gameViewModel',
						exclude: ['common']
					}*/
				]
			}
		}
	},
    less: {
      development: {
        options: {
          compress: false,
          yuicompress: false,
          optimization: 0
        },
        files: {
          "src/public/css/main.css": "src/public/css/less/main.less"
        }
      },
	  production: {
		options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          "src/public/css/main.css": "src/public/css/less/main.less"
        }
	  }
    },
    watch: {
      styles: {
        files: ['src/public/css/less/**/*.less','src/public/js/**/*.js'], // which files to watch
        tasks: ['less:development','requirejs:development'],
        options: {
          nospawn: true
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-requirejs');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['watch']);
  grunt.registerTask('development', ['less:development','requirejs:development']);
  grunt.registerTask('production', ['requirejs:production', 'less:production']);
};