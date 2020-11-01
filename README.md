# Search Engine
Search Engine using PHP with a crawler for both sites and images...

This project was made just for the learning purpose. So, I uploaded it on Github because i thought if anyone wants some of help whie making their own project, they may take this open source code and apply it with their own code.

# Steps To Start Working ⚒ 
1. Download a web server tool: my recommendation is <a href="https://www.apachefriends.org/">xampp</a>, you can download according to your PC requirments.

2. After this, install the software in the PC, and start the xampp server and one more thing that you only need to start first two modules which the required... 

<img src="https://s3.amazonaws.com/webucator-how-tos/2249.png" alt="Xampp user Interface">

If you face any help pls consult the internet there are alot of content available to guide you through the installation process.

3. Now you have completed the main installation process and succesfully started the server. Now head towards your brwoser and write the following URl 'localhost\dashboard'. If it doesn't gives an error then you are fully setup for the search engine.

4. Now open up the directory of Xampp in your local computer and find the the folder named as 'htdocs'. This is the main folder in which all the code which is to be shown on the website will be available...

<img src="https://mushfiqrazib.files.wordpress.com/2011/05/xampp_folder_structure1.png" alt="Xampp Folder">

  Just clone the repository in this directory.

5. Let's jump to the last process of completely start working with the search engine. Go to the browser and writhe the fllowing address in the search bar "localhost/phpmyadmin" and a new website will open. mostly like this...

<img src="https://www.phpmyadmin.net/static/images/screenshots/users.png" alt="Phpmyadmin user inerface">

  Just click on create a new database. 

6. Now write the name of your database mine is "wembra". If you give your own name, then you just need to change it in 'config.php' file. You can see the file by clicking this <a href="https://github.com/imran-prog/wembra-search-engine/blob/master/config.php">link</a>.

7. Now create three tables and name them as 'sites', 'images' and 'search' respectively and add the following fields to the table(sites): id, url, title, decription, keywords, clicks.

<img src="https://i.ibb.co/16L29Fh/Annotation-2020-11-01-113641.png" alt="Annotation-2020-11-01-113641" border="0">

  Now, for the table(images): id, siteurl, imageurl, alt, title, clicks, broken.
  
<img src="https://i.ibb.co/zHXQ6dj/Annotation-2020-11-01-114142.png" alt="Annotation-2020-11-01-114142" border="0">
  
  And for table(search): id, words, times.
  
8. Now You are all done. Just go to 'localhost/wembra-search-engine' or any name you have taken for the folder.

<img src="https://i.ibb.co/8bST0Zs/Annotation-2020-11-01-120019.png" alt="Annotation-2020-11-01-120019" border="0">

9. You are all done, Feel free to do your own tweeks.

# Work With The Crawler

1. I hope you have already configured PHP in your PC. If not then first go to the internet and search for the process of doing that. After that yuo can continue on.

2. Goto the folder where all the files of the search engine are store. open command prompt or any software you use. and write the following command...

php crawl.php

3. Your crawler is start, you can see in your Phpmyadmin tables it's continually adding data to the tables.

# Features

1. Fully Advanced Search Engine, It crawls both the websites and images fromt eh internet.
2. Info box of some results like (Google, Facebook etc)
3. It also have a fully advanced modalbox for the images results
4. Fully mobile responsive

# Credits

© 2018-2020 created by @imran-prog - Github: I hope You will Love It.
