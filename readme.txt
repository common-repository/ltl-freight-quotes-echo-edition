=== LTL Freight Quotes - Echo Edition ===
Contributors: enituretechnology
Tags: eniture,Echo,,LTL freight rates,LTL freight quotes, shipping estimates
Requires at least: 6.4
Tested up to: 6.6.1
Stable tag: 1.1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Real-time LTL freight quotes from Echo. Fifteen day free trial.

== Description ==

Echo (NYSE: Echo) is a leading global provider of transportation and logistics solutions. Its freight division, Echo Freight, provides freight related services, including less-than-truckload (LTL) freight. This application retrieves your negotiated Echo LTL freight rates, takes action on them according to the application settings, and displays the result as shipping charges in the WooCommerce checkout process. If you don’t have an Echo Freight account, call 800-333-7400, or register online [register online](https://www.echo.com/one-to-one/login).

**Key Features**

* Displays negotiated LTL shipping rates in the shopping cart.
* Provide quotes for shipments within the United States and to Canada.
* Custom label results displayed in the shopping cart.
* Display transit times with returned quotes.
* Product specific freight classes.
* Support for variable products.
* Define multiple warehouses.
* Identify which products drop ship from vendors.
* Product specific shipping parameters: weight, dimensions, freight class.
* Option to determine a product's class by using the built in density calculator.
* Option to include residential delivery fees.
* Option to include fees for lift gate service at the destination address.
* Option to mark up quoted rates by a set dollar amount or percentage.
* Works seamlessly with other quoting apps published by Eniture Technology.

**Requirements**

* WooCommerce 6.4 or newer.
* An account relationship with Echo Global Logistics.
* A API Key provided by ECHO Logistics.
* An API key from Eniture Technology.

== Installation ==

**Installation Overview**

Before installing this plugin you should have the following information handy:

* Your Echo account api key.

If you need assistance obtaining any of the above information, contact your local Echo Freight office
or call the [Echo Freight](http://echo.com) corporate headquarters at 1-800-333-7400.

A more comprehensive and graphically illustrated set of instructions can be found on the *Documentation* tab at
[eniture.com](https://eniture.com/woocommerce-echo-ltl-freight/).

**1. Install and activate the plugin**
In your WordPress dashboard, go to Plugins => Add New. Search for "LTL Freight Quotes - Echo Edition", and click Install Now.
After the installation process completes, click the Activate Plugin link to activate the plugin.

**2. Get a API key from Eniture Technology**
Go to [Eniture Technology](https://eniture.com/woocommerce-echo-ltl-freight/) and pick a
subscription package. When you complete the registration process you will receive an email containing your API key and
your login to eniture.com. Save your login information in a safe place. You will need it to access your customer dashboard
where you can manage your API keys and subscriptions. A credit card is not required for the free trial. If you opt for the free
trial you will need to login to your [Eniture Technology](http://eniture.com) dashboard before the trial period expires to purchase
a subscription to the API key. Without a paid subscription, the plugin will stop working once the trial period expires.

**3. Establish the connection**
Go to WooCommerce => Settings => Echo Freight. Use the *Connection* link to create a connection to your Echo account.

**5. Select the plugin settings**
Go to WooCommerce => Settings => Echo Freight. Use the *Quote Settings* link to enter the required information and choose
the optional settings.

**6. Enable the plugin**
Go to WooCommerce => Settings => Shipping. Click on the link for Echo Freight and enable the plugin.

**7. Configure your products**
Assign each of your products and product variations a weight, Shipping Class and freight classification. Products shipping LTL freight should have the Shipping Class set to “LTL Freight”. The Freight Classification should be chosen based upon how the product would be classified in the NMFC Freight Classification Directory. If you are unfamiliar with freight classes, contact the carrier and ask for assistance with properly identifying the freight classes for your  products.

== Frequently Asked Questions ==

= What happens when my shopping cart contains products that ship LTL and products that would normally ship FedEx or Echo? =

If the shopping cart contains one or more products tagged to ship LTL freight, all of the products in the shopping cart
are assumed to ship LTL freight. To ensure the most accurate quote possible, make sure that every product has a weight, dimensions and a freight classification recorded.

= What happens if I forget to identify a freight classification for a product? =

In the absence of a freight class, the plugin will determine the freight classification using the density calculation method. To do so the products weight and dimensions must be recorded. This is accurate in most cases, however identifying the proper freight class will be the most reliable method for ensuring accurate rate estimates.

= Why was the invoice I received from Echo Freight more than what was quoted by the plugin? =

One of the shipment parameters (weight, dimensions, freight class) is different, or additional services (such as residential
delivery, lift gate, delivery by appointment and others) were required. Compare the details of the invoice to the shipping
settings on the products included in the shipment. Consider making changes as needed. Remember that the weight of the packaging
materials, such as a pallet, is included by the carrier in the billable weight for the shipment.

= How do I find out what freight classification to use for my products? =

Contact your local Echo Freight office for assistance. You might also consider getting a subscription to ClassIT offered
by the National Motor Freight Traffic Association (NMFTA). Visit them online at classit.nmfta.org.

= How do I get a Echo Freight account? =

Check your phone book for local listings or call  1-800-333-7400.

= Where do I find my Echo Freight username and password? =

Usernames and passwords to Echo Freight’s online shipping system are issued by Echo Freight. If you have a Echo Freight account number, go to [Echo.com](http://echo.com) and click the login link at the top right of the page. You will be redirected to a page where you can register as a new user. If you don’t have a Echo Freight account, contact the Echo Freight at 1-800-333-7400.

= How do I get a API key for my plugin? =

You must register your installation of the plugin, regardless of whether you are taking advantage of the trial period or
purchased a API key outright. At the conclusion of the registration process an email will be sent to you that will include the
API key. You can also login to eniture.com using the username and password you created during the registration process
and retrieve the API key from the My API keys tab.

= How do I change my plugin API key from the trail version to one of the paid subscriptions? =

Login to eniture.com and navigate to the My API keys tab. There you will be able to manage the licensing of all of your
Eniture Technology plugins.

= How do I install the plugin on another website? =

The plugin has a single site API key. To use it on another website you will need to purchase an additional API key.
If you want to change the website with which the plugin is registered, login to eniture.com and navigate to the My API keys tab.
There you will be able to change the domain name that is associated with the API key key.

= Do I have to purchase a second API key for my staging or development site? =

No. Each API key allows you to identify one domain for your production environment and one domain for your staging or
development environment. The rate estimates returned in the staging environment will have the word “Sandbox” appended to them.

= Why isn’t the plugin working on my other website? =

If you can successfully test your credentials from the Connection page (WooCommerce > Settings > Echo Freight > Connections)
then you have one or more of the following licensing issues:

1) You are using the API key key on more than one domain. The API keys are for single sites. You will need to purchase an additional API key.
2) Your trial period has expired.
3) Your current API key has expired and we have been unable to process your form of payment to renew it. Login to eniture.com and go to the My API keys tab to resolve any of these issues.

== Screenshots ==

1. Quote settings page
2. Warehouses and Drop Ships page
3. Quotes displayed in cart

== Changelog ==

= 1.1.4 =
* Update: Product CSV import functionality.

= 1.1.3 =
* Fix: Restricted quote requests with incomplete data, ensuring smoother and more accurate processing.

= 1.1.2 =
* Update: Updated connection tab according to WordPress requirements 

= 1.1.1 =
* Update: Compatibility with WordPress version 6.5.2
* Update: Compatibility with PHP version 8.2.0

= 1.1.0 =
* Update: Introduced origin level markup and product level markup
* Update: Display "Free Shipping" at checkout when handling fee in the quote settings is  -100% .
* Update: Introduce the Shipping Logs feature.

= 1.0.7 =
* Update: Compatibility with WooCommerce HPOS(High-Performance Order Storage)

= 1.0.6 =
* Update: Updated logs end point URLS. 

= 1.0.5 =
* Update: Modified expected delivery message at front-end from “Estimated number of days until delivery” to “Expected delivery by”.
* Fix: nherent Flat Rate value of parent to variations. 

= 1.0.4 =
* Update: Added compatibility with "Address Type Disclosure" in Residential address detection

= 1.0.3 =
* Update: Improvements to the usage reporting in the plugin settings.

= 1.0.2 =
* Update: Compatibility with WordPress version 6.1
* Update: Compatibility with WooCommerce version 7.0.1

= 1.0.1 =
* Update: Banner images added to wordpress.org listings. 
* Fix: Fixed warraning message in hazardous material field

= 1.0 =
* Initial release.

== Upgrade Notice ==