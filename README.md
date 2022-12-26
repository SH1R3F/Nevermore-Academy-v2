# Nevermore Academy V2

---

## TODO

[x] Basic authentication via fortify\
[x] ACL without a package. Via Policies\
[x] Users management\
[x] Assignments\
[x] Submissions\
[x] Degrees for students submissions with database notifications\
[] Monthly reports for admins with notifications via database and mail\

---

## Features

Users can login / register and get the basic role of a student. Other roles must be added only by admin.\
Users can be associated with a single role. And roles can be have permissions set dynamically by authorized users. [TESTED]\
Users can be created / edited / deleted by authorized users. [TESTED]\
Assignments can be created / edited / deleted by authorized users. [TESTED]\
Teachers can only edit / show / delete his own assignments. [TESTED]\
Students can submit only one submission for assignment (if deadline didn't pass yet).
Teachers can list submissions of their assignments and give degrees for them.
