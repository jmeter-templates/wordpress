# WordPress JMeter Template
The most comprehensive performance testing coverage for Wordpress.
JMeter scripts and resources for baselining, load testing and stress testing any Wordpress Installation.

## Compatibility
This set of scripts is compatible with WordPress 4.0 and above, but might work on older versions. The repository contains resources to support different additional WP plugins.

It is built using JMeter version 2.11, but might work on older versions and requires JMeter Plugins (http://jmeter-plugins.org/).

## Coverage
The following activities are currently covered:
* Login
* Homepage
* View Blog Post
* RSS feed for Blog Comments / Blog Entries
* Create Blog Post
* Post a Comment
* Search

See below for Plugins coverage.

## Contents
**There are two main scripts:**

* **single-user.jmx**
* **loadtest.jmx**

The single-user script is used to run a single anonymous and a single authenticated user against the target system to collect response times while the system is idle. Those figures are considered as a baseline to compare against when you start load testing the system.
This script can also be used for Functional Testing.

The loadtest script is used for hitting the system with a predefined load scenario, it can be a realistic load (load test) as you expect to have on your go-live or as a stress test to hit your system with 10 (or 100) times more load than you actually expect to get.

**Additional components:**

* **export.jmx** - Used to pull existing data from your WP installation and populate the corresponding dataset directories with users, blogs, blog posts, pages and so on. The main scripts consume these dataset files for the actual testing. To be able to use this script, you should also put the following php script in a secured path in your WP installation:
* **php/export.php** - This is a drop-in WP plugin. This script should be placed somewhere secured but yet accessible. The export.jmx script is interacting with it to fetch existing content from the WP system.

## Usage
Set environment variable %JMETER_PATH% to point to the home of JMeter so this will be a valid path: %JMETER_PATH%\bin\jmeter.bat 

Run corresponding bat file:
single-user-LANDSCAPE.bat

## Plugins
Plugin developers may enhance this repository with additional plugins support.
Currently the following plugins are covered:

* **Shariff for Wordpress** version 1.0.11 - from https://wordpress.org/plugins/shariff-sharing/ - Get Sharing Counts
* **WordPress Popular Posts** version 3.2.1 - from https://wordpress.org/plugins/wordpress-popular-posts/ - View Counts Update
* **Like Posts and Comments** version 1.1 - from https://wordpress.org/plugins/likes-posts-comments/ - Like / UnLike Blog Posts and Comments

## Limitations and Scope
* Currently this set of scripts is fully compatible with single site installation and have partial support for multisite installations. Contributors are welcome to send a pull request with adjustments to enhance support for multisite installations.
* There is no mechanism to populate an empty installation with dummy content, the idea here is to fetch existing content and work with it. This results with more realistic tests, where content of the site is growing over time. If needed you should throw all existing content from time to time. Dummy content can be generated with any of http://ideaboxthemes.com/dummy-content-filler-plugins/ or Google for "wordpress dummy content" and find your way.
* There are no tools provided as part of this template for visualizing and comparing performance tests results. These tools are part of JMeter or JMeter Plugins.
* This set of scripts is designed to put your servers in focus - what kind of response times they provide and when will they fail. It doesn't cover any browser side logic, rendering or static resources performance and caching.
* Currently missing from scripts coverage: Pages, Categories, Admin UI.

## License
Apache License Version 2.0
http://apache.org/licenses/LICENSE-2.0.txt