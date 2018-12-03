# testapp
This is just a test app.

Warning: this app is tested in Firefox browser. Some elements may not be displayed properly inside other browsers!

--------------------------
Installation instructions:
--------------------------
- Clone the repository inside the application folder within your virtual machine:
      
        git clone https://github.com/reduvius/testapp.git

- You should add the folowing line inside your .yml hosts file within you virtual machine:

        - { host: "testapp.test", doc_root: "/vagrant/application/testapp" }

- You should add the following line at the end of your hosts file:

        192.168.33.10      testapp.test

- Import the database testapp.sql file located in testapp/db folder, using:
      
        mysql -u phplay -p < /vagrant/application/testapp/db/testapp.sql

              or 

        mysql -u phplay -p testapp < /vagrant/application/testapp/db/testapp.sql

- Type testapp.test adress inside your web browser to access the app
