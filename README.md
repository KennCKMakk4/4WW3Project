# 4WW3Project
Link to server: http://18.189.211.159/RangersWatch/main.html

## Team Name
Pack Mules

## Member
Kenneth Mak, makk4, 001318946

## Site
**Ranger's Watch** is an online database of archery centres, shops, and ranges. Users are able to search, view, rate, and submit new locations to the database.

## Add-On
Only did a part of task 2, which is the addition of a video element in the submission and object preview page.

## Site Map
**[main.html](http://18.189.211.159/RangersWatch/main.html)**

is the home page for the project. Can be navigated to at any point with the Home button in the header navigation menu.

**[search.html](http://18.189.211.159/RangersWatch/search.html)**
can be accessed with the second button on the navigation menu, this takes you to the page where you can search for an centre. 

At the moment, clicking on the ``Search`` button regardless of inputs will take you to a sample **results** page.

- **[results.html](http://18.189.211.159/RangersWatch/results.html)**    
  - can only be accessed by selecting the ``Search`` button from the search page. Displays a sample GoogleMaps image of the resultant search, as well as a table of nearby archery centres. Clicking on the name of any of the resulting locations will take you to a sample **objects** page
- **[object.html](http://18.189.211.159/RangersWatch/object.html)**    
  - can only be accessed via clicking on the name of a location from the ``Results`` page. Currently shows a sample location. From here, you are able see its current ratings and reviews, its address and location on a GoogleMaps image, and a preview video (if applicable).

**[submission.html](http://18.189.211.159/RangersWatch/submission.html)** can be accessed with the third button on the navigation menu. Here you can submit a new location to the database by filling out the details on the form.


**[signin.html](http://18.189.211.159/RangersWatch/signin.html)** can be accessed with the fourth button on the navigation menu. This brings you to a page with a simple login form.


**[registration.html](http://18.189.211.159/RangersWatch/registration.html)** can be accessed with the fifth button on the navigation menu. This brings you to a sign-up/registration page to create an account. 

## Additional Notes
### Project Organization
```html``` files are all located in the root folder. ```css``` styling sheets are located inside the ```assets/css``` folder. All additional images and videos can be located inside the ```assets/img``` and ```assets/media``` folder respectively.

### CSS organization and styling 
The most important `css` file is `global_style.css`. This determines the styling for most of the site (i.e. the header, footer, navigation menu, colors). After that, the rest of the `css` files are then used for more specific purposes where applicable. For example, `main.css` is used for styling `main.html`, and `results.css` is used for styling `results.html`.

`forms.css` is a mix of both ideas, and is used whenever a form needs to be created on the screen to receive user input. This is used in `registration.html`, `search.html`, `signin.html`, and `submission.html`. Essentially, whenever we need input from the user, we will then call this styling sheet in. We refrained from including this inside `global_style.css` since not every web page will need to create a form.