PHP Quiz Generator
==================

PHP Quiz Generator is an app that can help you construct programming and/or mathematics quizzes online, and collect the answers from your students. Also this app can help you grade the students' assignments.

The app uses its own syntax for creating those types of quizzes:

* Single selection problems
* Multiple selection problems
* Blank filling problems
* Programming problems

The app is written in PHP. And it uses file system for persistent data storages.


Syntax
------

In general, express your quiz ths way:

```
Deadline: 2013-04-01
Hard deadline: 2013-05-01


+1 This is a sample problem.
   Choose one of the selection below you think is correct.

@@ This one is not correct.
@@ This one might be correct.
@* This one is correct.


+1 This is another sample problem.
   Choose the selections below you think are correct.

   (Note that there might be more than one correct selections.)

## This one is not correct.
## This one might be correct.
#* This one is correct.
#* This one is correct, too.


+1 Please input your text answer below:

[ /Regular expression for correct answer/ ]


+1 Please enter your code:

{ Name of test suites for the code }
```


About the Author
----------------

LIU Yue &lt;euyuil@acm.org&gt;<br />
Tongji University, Shanghai, China


Thanks to
---------

### MathJax

* http://www.mathjax.org/
* http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML

### jQuery

* http://jquery.com/
* http://code.jquery.com/jquery-1.9.1.min.js

### Ace

* http://ace.ajax.org/
