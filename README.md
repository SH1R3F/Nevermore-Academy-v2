# Nevermore Academy V2

---

## TODO

[x] Basic authentication via fortify\
[x] ACL without a package. Via Policies\
[x] Users management\
[x] Assignments\
[x] Submissions\
[x] Degrees for students submissions with database notifications\
[x] Monthly reports for admins with notifications via database and mail\
[x] Send both email and database notification to teachers when someone submit to their assignment\
[x] Profile pictures for users when they register or being managed from dashboard (Spatie media library)\
[x] Mobile verification\
[x] Email verification\
[x] Two factor authentication (without a package & without using the default fortify 2fa feature)\
[x] Push notification to chosen types (mail, db, and sms)\
[x] Localization on both the backend and frontend statically and dynamically through a URL segment\
[x] Provide API on a subdomain\
[x] Articles system [CRUD] with unique generated slug & images.\
[x] Morph taggables.

---

## Features

Users can login / register and get the basic role of a student. Other roles must be added only by admin.\
Users can be associated with a single role. And roles can be have permissions set dynamically by authorized users. [TESTED]\
Users can be created / edited / deleted by authorized users. [TESTED]\
Assignments can be created / edited / deleted by authorized users. [TESTED]\
Teachers can only edit / show / delete his own assignments. [TESTED]\
Students can submit only one submission for assignment (if deadline didn't pass yet).[TESTED]\
Teachers can list submissions of their assignments and give degrees for them. [TESTED]\
When teachers degree a submission database notification will be pushed to student.[TESTED]\
Every month a report with new assignmens and submissions for the month will be automatically sent to superadmins.\
Also you can use `php artisan nevermore:reports` to send mailable report to admin\

Mobile verification done using twilio and twilio-notification-channel package\
Users are required to verify their mobile number in order to use our services\
Users are not required to verify their email but they will always have an alert that they need to verify their email or they won't receive any email notification\
A listener is hooked to NotificationSending event that will fail any notification that is sent to a user that didn't verify his email;\
If admin changes user email or mobile verification is reset and resent (Only if User model is implementing required interfaces)\
On user registration they are required to upload their profile pictures which is handled by Spatie media library.\
When user is edited / deleted media is automatically deleted / updated\
What i wanna do is: if user login with a verified email or a verified mobile he will be automatically asked for a 2fa code sent upon his choice either via email or via mobile. otherwise (if user didn't verify any he will be logged in normally.) [DONE]\
When user log in (If he has one option verified email|mobile) He will be automatically asked to verify 2FA to be able to use our service.\
2FA verification method is optional. user can choose between mobile and email.\
Superadmin can push a notification message for the type of users he can choose (all superadmins, all teachers, or all students) as well as choosing which type of notifications (sms, email, in-app notifications, or all)./

Adding localization through url is a little bit tricky.\
Problems I'm facing:\

-   All routes where hardcoded in views `/register`, `/login`. So when I needed to append a locale prefix to them it's gonna be unpractical to append to them one by one. Fortunately Ziggy is here with the solution.
-   Controllers that requires a parameter from the route expects the order of passed parameters to have the locale at first. Causes a problem with all other paramters. I Walked around it by a little trick to forget the locale param after using it in middleware `$request->route()->forgetParameter('locale');`
-   Fortify codes are hidden with now way to update the logout redirection which leads to '/' without specifying locale. thus we would be redirected to other locales we don't want. Solved by creating another response and bind it instead of fortify logout response.
-   Localizing records returned from database. Google says there're two ways to do this. an old insuffecient way (Saving translations in same table as different columns for each language you wanna add). and another better way by saving it in different tables for translation (Or maybe in same table with a different way of saving).
    I'll be using the second way with an approach of saving it in same table but as json data by Spatie/Translatable package.
