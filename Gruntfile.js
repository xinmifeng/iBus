module.exports=function(grunt){
	grunt.initConfig({
		pkg:grunt.file.readJSON('package.json')
	});
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-cmd-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-haml');
	grunt.registerTask('default',['haml']);
}
