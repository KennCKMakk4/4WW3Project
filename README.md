# 4WW3Project
Link to server: http://18.189.211.159/RangersWatch/main.html

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
**[main.html](http://18.189.211.159/RangersWatch/main.html)**

is the home page for the project. Can be navigated to at any point with the Home button in the header navigation menu.

**[search.html](http://18.189.211.159/RangersWatch/search.html)**
can be accessed with the second button on the navigation menu, this takes you to the page where you can search for an centre. 

At the moment, clicking on the ``Search`` button regardless of inputs will take you to a sample **results** page.

- **[results.html](http://18.189.211.159/RangersWatch/results.html)**    
  - can only be accessed by selecting the ``Search`` button from the search page. Displays an interactive map of nearby archery centres, as well as a table of nearby archery centres. Clicking on the name of any of the resulting locations, or on the popup pinned on the map, will take you to a sample **objects** page
- **[object.html](http://18.189.211.159/RangersWatch/object.html)**    
  - can only be accessed via clicking on the name of a location from the ``Results`` page. Currently shows a sample location. From here, you are able see its current ratings and reviews, its address and location on an interactive map, and a preview video (if applicable).

**[submission.html](http://18.189.211.159/RangersWatch/submission.html)** can be accessed with the third button on the navigation menu. Here you can submit a new location to the database by filling out the details on the form.


**[signin.html](http://18.189.211.159/RangersWatch/signin.html)** can be accessed with the fourth button on the navigation menu. This brings you to a page with a simple login form.


**[registration.html](http://18.189.211.159/RangersWatch/registration.html)** can be accessed with the fifth button on the navigation menu. This brings you to a sign-up/registration page to create an account. 

## Additional Notes
### Project Organization
```html``` files are all located in the root folder. ```css``` styling sheets are located inside the ```assets/css``` folder. All additional images and videos can be located inside the ```assets/img``` and ```assets/media``` folder respectively.

### CSS organization and styling 
The most important `css` file is `global_style.css`. This determines the styling for most of the site (i.e. the header, footer, navigation menu, colors). After that, the rest of the `css` files are then used for more specific purposes where applicable. For example, `main.css` is used for styling `main.html`, and `results.css` is used for styling `results.html`.

`forms.css` is a mix of both ideas, and is used whenever a form needs to be created on the screen to receive user input. This is used in `registration.html`, `search.html`, `signin.html`, and `submission.html`. Essentially, whenever we need input from the user, we will then call this styling sheet in. We refrained from including this inside `global_style.css` since not every web page will need to create a form.


# Part Two
## Form Validation
Added form validation to all applicable pages. These pages are `registration.html`, `signin.html`, `search.html`, and `submission.html`. 

The `submission.html` validates using the `required` and `pattern` tags with HTML5 and CSS. The `registration.html` validates with JavaScript code, as requested in the assignment page. 

All other pages uses both types of validation, where applicable.

## Geolocation and Interactive Map
### Geolocation
Added buttons to forms `search.html` and `submission.html` where, when pressed, will request access to user's location. If given, it will write the current latitude and longitude values into their respective text box.

### Interactive Map
Using OpenStreetMaps, we inserted a map into the `results.html` and `object.html` pages. In `results.html`, we center the user around a certain location (currently set to McMaster University, Hamilton, Ontario). We also place pins at the addresses of the sample results found.

In `object.html`, we center an interactive map around the sample object that was hard coded in part 1.