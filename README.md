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
[] Profile pictures for users when they register or being managed from dashboard (Spatie media library)\
[x] Mobile verification\
[] Email verification\
[] Two factor authentication\
[] Push notification to chosen types (mail, db, and sms)\

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

Mobile verification done using twilio and twilio-notification-channel package
