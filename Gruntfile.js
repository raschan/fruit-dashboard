module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    bower: grunt.file.readJSON('bower.json'),
    config: {
      from: 'bower_components',
      dist: 'public/dist'
    },
    jshint: {
        options: {
          "maxparams": 4,
          "maxdepth": 2,
          "maxcomplexity": 6
        },
        all: [
            'Gruntfile.js'
        ]
    },
    // copy the fonts
    copy: {
      dist: {
        files: [{
          expand: true,
          cwd: '<%= config.from %>/font-awesome',
          src: 'fonts/*',
          dest: '<%= config.dist %>'
        },
        {
          expand: true,
          cwd: '<%= config.from %>/paymentfont',
          src: 'fonts/*',
          dest: '<%= config.dist %>'
        },
        {
          expand: true,
          flatten: true,
          src: '<%= config.from %>/**/*min.css',
          dest: '<%= config.dist %>/css'
        },
        {
          expand: true,
          flatten: true,
          src: '<%= config.from %>/**/*min.js',
          dest: '<%= config.dist %>/js'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/used_assets/Pixeladmin-1.3.0/stylesheets/pixel-admin.min.css',
          dest: '<%= config.dist %>/css'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/used_assets/Pixeladmin-1.3.0/stylesheets/themes.min.css',
          dest: '<%= config.dist %>/css'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/used_assets/Pixeladmin-1.3.0/stylesheets/widgets.min.css',
          dest: '<%= config.dist %>/css'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/used_assets/Pixeladmin-1.3.0/stylesheets/pages.min.css',
          dest: '<%= config.dist %>/css'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/used_assets/Pixeladmin-1.3.0/javascripts/pixel-admin.min.js',
          dest: '<%= config.dist %>/js'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/css/custom.css',
          dest: '<%= config.dist %>/css'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/js/google_events.js',
          dest: '<%= config.dist %>/js'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/js/mixpanel_event.js',
          dest: '<%= config.dist %>/js'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/js/mixpanel_user.js',
          dest: '<%= config.dist %>/js'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/js/google_analytics.js',
          dest: '<%= config.dist %>/js'
        },
        {
          expand: true,
          flatten: true,
          src: 'public/js/intercom_io.js',
          dest: '<%= config.dist %>/js'
        }]
      }
    },
    concat: {
      options: {
        // define a string to put between each file in the concatenated output
        separator: ';'
      },
      css: {
        src: [
          'public/dist/css/*.css'
          ],
        dest: 'public/dist/css/<%= pkg.name %>.css'
      },
      js : {
        src: [
          'public/dist/js/*.js'
        ],
        dest: 'public/dist/js/<%= pkg.name %>.js'
      }
    },
    cssmin : {
        css:{
            src: 'public/dist/css/<%= pkg.name %>.css',
            dest: 'public/dist/css/<%= pkg.name %>.min.css'
        }
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
      },
      dist: {
        files: {
          'public/dist/js/<%= pkg.name %>.min.js': ['<%= concat.js.dest %>']
        }
      }
    }
  });

  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  grunt.registerTask('default', [ 'jshint', 'copy', 'concat:css', 'cssmin:css', 'concat:js', 'uglify' ]);

};