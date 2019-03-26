# Report Management System (RMS)
A Report Management System (Archive) with different functionalities such as groups, roles and reports management.

### Development Progress
[==========] 100%

### Initial Database Schema Model
![schema](https://i.imgur.com/xFAQUjA.png)


### Features
* Groups: Admin can create groups to categorize reports and members.
* Reports: Users can create reports belonging to groups they are enrolled in.
* Files: Reports can have images as well as audio files stored privately and securely. All files are served for authorized members only.
* Group Management: Admin can create groups and assign users to these groups. Users can access reports on a group only if they are enrolled in it.
* Roles: Admin, User.
* Responsiveness: System is reponsive and can work in any device running on any screen width.
* Admin Panel: Admin can access, edit, delete all reports, groups, users through the integrated admin panel.
* Auth & Auth: authentication and authorization provided for security.
* API endpoint: Available to port existing reports or bulk store reports into the system.

### API Request
To access and use the system's API, configure your **api token** in the env file and use it as a Baerer token for authorization when sending requests.\
**Request Method**: POST\
**Endpoint**: /api/v1/storeReports\
**Authorization**: Baerer token.\
Example:
```javascript
[
	{ // Minimal request
		"title": "test audio upload", //required
		"description": "lorem ipsum", //required
		"tags": "testTagNew, testNewTag", //required
		"group": "GroupA", //required
		"user_id": 1 //required
	},
	{ // With photos and audios
		"title": "test audio upload",
		"description": "lorem ipsum",
		"tags": "testTagNew, testNewTag",
		"group": "GroupA",
		"user_id": 1,
		"photos": [ // provide an array of Base64 photos
		    { "name": "BASE64PhotoHere" },
		    { "name": "BASE64PhotoHere" },
		],
		"audios": [ // provide an array of Base64 audio files
			{ name: "Base64AudioFileHere" }
		]
	}
]
```
