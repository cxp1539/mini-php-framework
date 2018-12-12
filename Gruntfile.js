module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
            },
            static_mappings:{
                files:[{
                    src:'statics/js/index/index.js',
                    dest:'statics/js/index/index.min.js'
                },{
                    src:'statics/js/index/test.js',
                    dest:'statics/js/index/test.min.js'
                }]
            }
        },    
        concat: {
            options: {
                separator: ';'
            },
            dist: {
                src: ['statics/js/index/*.min.js'],
                dest: 'statics/release_js/index/<%= pkg.name %>_index.js'
            }
        },
        watch: {
            files: ['statics/js/index/*.js'],
            tasks: ['uglify', 'concat']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['uglify','concat','watch']);

};