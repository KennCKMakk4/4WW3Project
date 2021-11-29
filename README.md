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

# Part One

## Add-On
Only did a part of task 2, which is the addition of a video element in the submission and object preview page.

## Site Map
**[main.php](https://kennsite.live/RangersWatch/main.php)**

is the home page for the project. Can be navigated to at any point with the Home button in the header navigation menu.

**[search.php](https://kennsite.live/RangersWatch/search.php)**
can be accessed with the second button on the navigation menu, this takes you to the page where you can search for an centre. 

At the moment, clicking on the ``Submit`` button will try and validate the form. In order to go to the next page, use the second button `"Search (Move to Results.php)"` to take you to a sample **results** page.

- **[results.php](https://kennsite.live/RangersWatch/results.php)**    
  - can only be accessed by selecting the ``Search`` button from the search page. Displays an interactive map of nearby archery centres, as well as a table of nearby archery centres. Clicking on the name of any of the resulting locations, or on the popup pinned on the map, will take you to a sample **objects** page
- **[object.php](https://kennsite.live/RangersWatch/object.php)**    
  - can only be accessed via clicking on the name of a location from the ``Results`` page. Currently shows a sample location. From here, you are able see its current ratings and reviews, its address and location on an interactive map, and a preview video (if applicable).

**[submission.php](https://kennsite.live/RangersWatch/submission.php)** can be accessed with the third button on the navigation menu. Here you can submit a new location to the database by filling out the details on the form.


**[signin.php](https://kennsite.live/RangersWatch/signin.php)** can be accessed with the fourth button on the navigation menu. This brings you to a page with a simple login form.


**[registration.php](https://kennsite.live/RangersWatch/registration.php)** can be accessed with the fifth button on the navigation menu. This brings you to a sign-up/registration page to create an account. 

## Additional Notes
### Project Organization
```html``` files are all located in the root folder. ```css``` styling sheets are located inside the ```assets/css``` folder. All additional images and videos can be located inside the ```assets/img``` and ```assets/media``` folder respectively.

### CSS organization and styling 
The most important `css` file is `global_style.css`. This determines the styling for most of the site (i.e. the header, footer, navigation menu, colors). After that, the rest of the `css` files are then used for more specific purposes where applicable. For example, `main.css` is used for styling `main.php`, and `results.css` is used for styling `results.php`.

`forms.css` is a mix of both ideas, and is used whenever a form needs to be created on the screen to receive user input. This is used in `registration.php`, `search.php`, `signin.php`, and `submission.php`. Essentially, whenever we need input from the user, we will then call this styling sheet in. We refrained from including this inside `global_style.css` since not every web page will need to create a form.


# Part Two
## Form Validation
Added form validation to all applicable pages. These pages are `registration.php`, `signin.php`, `search.php`, and `submission.php`. 

The `submission.php` validates using the `required` and `pattern` tags with HTML5 and CSS. The `registration.php` validates with JavaScript code, as requested in the assignment page. 

All other pages uses both types of validation, where applicable.

## Geolocation and Interactive Map
### Geolocation
Added buttons to forms `search.php` and `submission.php` where, when pressed, will request access to user's location. If given, it will write the current latitude and longitude values into their respective text box.

### Interactive Map
Using OpenStreetMaps, we inserted a map into the `results.php` and `object.php` pages. In `results.php`, we center the user around a certain location (currently set to McMaster University, Hamilton, Ontario). We also place pins at the addresses of the sample results found.

In `object.php`, we center an interactive map around the sample object that was hard coded in part 1.




# External Resources
https://serverfault.com/questions/139323/how-to-bind-mysql-server-to-more-than-one-ip-address
https://www.digitalocean.com/community/tutorials/how-to-allow-remote-access-to-mysql
https://stackoverflow.com/questions/1559955/host-xxx-xx-xxx-xxx-is-not-allowed-to-connect-to-this-mysql-server
Help with allowing access to database, when host is not allowed to connect.