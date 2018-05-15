var fs = require('fs');
var AWS = require('aws-sdk');
var s3 = new AWS.S3();

fs.readdir(path, function(err, items) {
	for(var i = 0, n = items.length; i < n; i++) {
		var params = {
			Bucket: 'aminsp',
			Key: 'files_old/' + items[i];
		};
		s3.getObject(params, function(err, data){
			if(err) {
				console.log('file not found....uploading');
			} else {
				console.log('file found...unlinking');
				//fs.unline(items[i]);
			}
		});
		// if exists
			//fs.unlink(items[i]);
		//else
			//Upload??
	}
});