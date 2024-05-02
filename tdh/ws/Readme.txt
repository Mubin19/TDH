How to run this script
1. Download and Unzip file on your local system.
2. Put this file inside root directory
3. Database Configuration
Database Configuration
Open phpmyadmin
Create Database webservices
Import database signup.sql (available inside zip package)

For Signup

requested url for service http://localhost/ws/signup.php
After that use postman app to hit the WebService.

Input parameters will be like this
{
“fullName”: “John Doe”,
“gender”:”Male”,
“number”:”7556645345342″,
“email”:”john@anc.com”,
“password”: “Demo”
}
Output will be in JSON format 
For successful attempt 
{“StatusCode”:”200″,”StatusDescription”:”Registration successful”}
For unsuccessful attempt 
{“StatusCode”:”400″,”StatusDescription”:”Something went wrong. Please try again.}


For Signin / Login

requested url for service http://localhost/ws/signin.php
Input parameters will be like this
{
“email”:”john@anc.com”,
“pwd”: “Demo”
}

Output will be in JSON format 

For successful attempt 
{“StatusCode”:”200″,”StatusDescription”:{“UserId”:”1″,”FullName”:”John Doe”}}

For unsuccessful attempt 
Case 1
{"StatusCode":"205","StatusDescription":"Email id already exist. Please try with diffrent email."}
Case 2
{“StatusCode”:”400″,”StatusDescription”:”Something went wrong. Please try again.}