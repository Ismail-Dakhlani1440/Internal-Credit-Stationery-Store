# Git Flow Recap

Git Flow is a branching model based on two permanent branches:
<span style="color:#4CAF50;"><strong>main</strong></span> and
<span style="color:#2196F3;"><strong>develop</strong></span>.

<span style="color:#4CAF50;"><strong>main</strong></span> contains production-ready code,  
<span style="color:#2196F3;"><strong>develop</strong></span> is the integration branch where all work is merged.

Git Flow is initialized using:
`git flow init`

All <span style="color:#FF9800;"><strong>feature</strong></span> and
<span style="color:#FF5722;"><strong>bugfix</strong></span> branches must be created
<strong>only from <span style="color:#2196F3;">develop</span></strong>.  
Creating branches from <span style="color:#4CAF50;">main</span> is not allowed.

Feature branches are created using:
`git flow feature start feature-name`

Bugfix branches are created using:
`git flow bugfix start bugfix-name`

Before pushing your branch and creating a pull request, you must make sure it is up to date with
<span style="color:#2196F3;"><strong>develop</strong></span>.
First update your local develop branch using  
`git checkout develop` then `git pull origin develop`.  
Then pull develop into your working branch using  
`git checkout your-branch` then `git merge develop`.

Once the pull request is approved and merged into
<span style="color:#2196F3;"><strong>develop</strong></span>,
the feature or bugfix branch must be
<span style="color:#9E9E9E;"><strong>closed / deleted</strong></span>
both remotely and locally.

Once completed, feature branches are merged back into
<span style="color:#2196F3;">develop</span> using  
`git flow feature finish feature-name`  
and bugfix branches using  
`git flow bugfix finish bugfix-name`.

The <span style="color:#4CAF50;"><strong>main</strong></span> branch is protected.  
<span style="color:#F44336;"><strong>No one is allowed to push or merge into main except the Scrum Master.</strong></span>
