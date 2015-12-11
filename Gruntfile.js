module.exports = function(grunt) {

  grunt.initConfig({

    concat: {
      js: {
        src: [
          './bower_components/jquery/dist/jquery.js',
          './bower_components/bootstrap-sass-official/vendor/assets/javascripts/bootstrap.js',
          './resources/assets/javascripts/*.js'
        ],
        dest: './public/assets/javascripts/application.js'
      }
    },
    uglify: {
      options: {
        mangle: false
      },
      js: {
        files: {
          './public/assets/javascripts/application.js': './public/assets/javascripts/application.js'
        }
      }
    },    
    sass: {
      development: {
        files: {
          "./public/assets/stylesheets/application.css":"./resources/assets/stylesheets/application.sass",
            "./public/assets/stylesheets/mobile.css":"./resources/assets/stylesheets/mobile.sass",
            "./public/assets/stylesheets/tablet.css":"./resources/assets/stylesheets/tablet.sass"
        }
      }
    },
    watch: {
      js: {
        files: [
          './bower_components/jquery/dist/jquery.js',
          './bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.js',
          './resources/assets/javascripts/*.js'
          ],
        tasks: ['concat:js', 'uglify:js']
      },
      sass: {
        files: ['./resources/assets/stylesheets/*.sass'],
        tasks: ['sass']
      }
    }    
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['watch']); 
};