# 4WW3Project
Link to server: https://kennsite.live/RangersWatch/main.php
Link to server (using IP address, unsecure): http://18.189.211.159/RangersWatch/main.php

Link to GitHub repo: https://github.com/KennCKMakk4/4WW3Project


## Team Name
Pack Mules

## Member
Kenneth Mak, makk4, 001318946

## Site
**Ranger's Watch** is an online database of archery centres, shops, and ranges. Users are able to search, view, rate, and submit new locations to the database.

## Database and Table Creation
The SQL query for generating the Database and Table: `databaserangerswatch.sql`

# Part Three
## Changes
In Part 3, dynamic loading from a backend was implemented for all parts of the site. New features including submitting, searching, and loading locations from a table. An account system was created to allow for users to sign in, sign out, and to register an account. Some features, such as submitting locations or reviews, will no longer be accessible without logging in. The header will now change to display your login status. 

## Changes to Each Page
**[main.php](https://kennsite.live/RangersWatch/main.php)**
- Not much changes in this one, just changing the header and footer content to be included from a php file. The header files will also now reflect the session status of a client.


**[search.php](https://kennsite.live/RangersWatch/search.php)**
- The search button will now send a get method to `results.php` with the given parameters. 
- It will only function if at least one of the `Name` or `Location` is filled in. Both can be filled in to make the search more accurate.
  - `Name` is matched in the query with `LIKE`
  - `Location` is used for calculating the distance from the results to this location 
- `Ratings` is not required, but will also be sent if the user changes the minimum rating as part of their search.

**[results.php](https://kennsite.live/RangersWatch/results.php)**    
- accessed by selecting the `Search` button from the search page
- Sends a query to the database with parameters given from the search page. Displays an interactive map of nearby archery centres that fit the given search filters 
- a table of nearby archery centres also displays the results 
  - Hovering over a row in the table will focus the interactive map to its location
  - Clicking on the headers of the table will sort by that column
  - A `Distance` Column is included if the previous search filters gave a location 
- Clicking on the name of any of the resulting locations, or on the popup pinned on the map, will take you to that location's page

**[object.php](https://kennsite.live/RangersWatch/object.php)**    
- can only be accessed via clicking on the name of a location from the `Results` page
- Takes in an `id` in the `GET` method that contains this location's details
- All details from this page are dynamically generated
  - Video files are also rendered if there was one created with it. Note the max size is only 150MB for a file to be uploaded.
  - Images and Videos are linked by requesting a URL to a file inside the Amazon S3 Bucket
- Reviews are located at the very bottom of the page
  - Users can submit a review by clicking on the link right above all user reviews
  - Note: You must be signed in to review a location

**[review.php](https://kennsite.live/RangersWatch/review.php)**
- Can only be accessed via clicking a link from the `object.php` page to review that location
- Takes in an `id` in the `GET` method - used for DB linking
- You select a rating by clicking on one of the 5 stars.
- You can also provide a description.
- On submit, it goes to `action_review.php`, whcih submits the review and then goes to the object's page you just reviewed

**[submission.php](https://kennsite.live/RangersWatch/submission.php)** 
- can be accessed with the third button on the navigation menu. Here you can submit a new location to the database by filling out the details on the form.
- You must be logged in to access this page - failure to do so will send you to `signin.php`
- If you are logged in, you can fill out the details of the form
  - You must upload an image file (<150MB)
  - You can optionally upload a video file
  - All required fields have an asterisk (*) next to the label
- On submit, it sends the parameters to `action_submit.php` which attempts to insert the values and upload the files
  - It then goes to the new location that was just created
  - Files are uploaded to a Amazon S3 Bucket


**[signin.php](https://kennsite.live/RangersWatch/signin.php)** 
- can be accessed with the fourth button on the navigation menu. This brings you to a page with a simple login form, where you can submit your details
- calls `action_signin.php` and passes the parameters. Upon a successful authentication, sets the session tokens and provides a cookie for 1 day.
  - Afterwards goes to `main.php`
  - On failure, returns back to `signin.php`

**[signout.php](https://kennsite.live/RangersWatch/signout.php)** 
- can be accessed from the header while logged in as the last button in the row or column. This simply logs you out and returns you to the `signin.php` page. Unsets most session tokens.

**[registration.php](https://kennsite.live/RangersWatch/registration.php)** 
- can be accessed with the fifth button on the navigation menu while not logged in. This brings you to a sign-up/registration page to create an account. 
- Calls `action_register.php` when the form is validated and passes all parameters
  - Creates a call to the database and inserts a new record
  - Afterwards, logs the user in and goes to `main.php`
  - If there is an error (i.e duplicate record, not validated value), returns back to `registration.php`

## Backend Services
### AWS EC2
Hosts the website, as well as the location of the MYSQL server. It's connection information is stored inside `dbconn.php` - this file is not placed in the repository for security purposes. Upon `require` of this file, it will generate a `$conn` variable containing a PDO connection to the server

### Amazon S3 Bucket
Hosts the location for where all files for a location's image and video will be stored. It's connection information is stored inside `bktconn.php` - this file is not placed in the repository for security purposes. Upon `require` of this file, it will generate a `$S3Client` variable which is a connection to the bucket for uploading and getting URLs to files from.

## Other Notes:
The max size of video/image upload is 150 MB.

Multiple edits were done inside php.ini to enable:
- increased upload file size
- enable PDOs

Credentials to the MYSQL Database and the Amazon S3 Bucket is stored inside `bktconn.php` and `dbconn.php`. They initialize a `$S3Client` and a `$conn` respectively, which is the connection to the desired service. They are not included inside of the GitHub repository for security - instead 


# External Resources
## Connecting to Database
- https://serverfault.com/questions/139323/how-to-bind-mysql-server-to-more-than-one-ip-address
- https://www.digitalocean.com/community/tutorials/how-to-allow-remote-access-to-mysql
- https://stackoverflow.com/questions/19101243/error-1130-hy000-host-is-not-allowed-to-connect-to-this-mysql-server
- https://stackoverflow.com/questions/1559955/host-xxx-xx-xxx-xxx-is-not-allowed-to-connect-to-this-mysql-server
  - Help with allowing access to database, when host is not allowed to connect.
- https://stackoverflow.com/questions/30358737/php-file-upload-error-tmp-name-is-empty/46035364
  - issues with max file during upload

## Connecting to S3 Bucket
- https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/s3-presigned-url.html

## Haversine formula for LatLong distances
- https://www.geeksforgeeks.org/haversine-formula-to-find-distance-between-two-points-on-a-sphere/

## LatLong from Address
- https://www.latlong.net/
