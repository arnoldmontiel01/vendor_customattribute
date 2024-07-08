<div align="center">


# Magento 2.0 Senior Developer Exercise

[Overview](#Overview) - [Requirements](#Requirements) - [Installation](#installation) - [Test](#test) - [Explanation](#explanation)

</div>

## Overview

This Magento 2 module adds a new product attribute custom_text_attribute, modifies the product detail page to display this attribute, and includes a custom console command to update the values of this attribute for all products. Additionally, it implements JavaScript validation for the custom attribute on the frontend and adds feature toggle functionality to control the availability of the custom attribute. The module also extends Magento's core functionality by integrating the custom attribute within the minicart.


## Requirements

The module was developed on top of Magento 2.4.6

## Installation

- Place the module in the app/code/Vendor/CustomAttribute directory.
``` sh
php bin/magento module:enable Vendor_CustomAttribute
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:clean

```

## Test

### Access information
#### ssh:
- Credentials will be shared via email.
``` sh
cd magento/public
```

#### http:
- Frontend https://test.arnoldmontiel.com.ar
- Backend https://test.arnoldmontiel.com.ar/admin_1fkni1


### Commands

- The module creates the following commands

Update the attribute value for all products
``` sh
php bin/magento custom:attribute:update "example value"
```
Enable the module, so the custom attribute get shown in the frontend area
``` sh
php bin/magento custom:attribute:enable
```
Disable the module, so the custom attribute does not get shown in the frontend area
``` sh
php bin/magento custom:attribute:disable 
```
### Validation

- 1 - Access a product detail page.
- 2 - You will se a new input field named "Custom Attribute" just under "add to wish list" option.
- 3 - The new field will validate the filled information, it must be at least 3 characters (it can't be empty neither).
- 4 - You can click on the "validate" button, if the validation passes it will summit the value and will show an according message.

### Toggle Functionality
The toggle feature has 2 different approaches 
- 1 - Command line:

Enable the module, so the custom attribute get shown in the frontend area

``` sh
php bin/magento custom:attribute:enable

```
Disable the module, so the custom attribute does not get shown in the frontend area
``` sh
php bin/magento custom:attribute:disable 

```
- 2 - Login into the admin area and go to: Stores > Configuration > CUSTOM ATTRIBUTE > Settings

There will be an Enable => YES/NO option.

## Explanation

### Custom Attribute
Using EAV I added a new text attribute named "custom_text_attribute". This type of attributes can be added through the Admin Area,
but also during a Module installation/update. In this case I created a InstallData class with its corresponding information. 

### Commands
3 new commands were added to the system, 2 of them are essentially the same, they "enable" or "disable" a config value.
The other one, will get a list of all products IDs and using the ProductAction Model will update the new attribute, using this model is the more efficient way to update attributes in Magento 2.

### JS Validation
In order the accomplish this task I updated the product view layout and added a new block, it renders a form with an input element, it shows the new custom attributes.
Then I created a new JS validator element, adding the new rules and attached the validation to the new input field and form.
I also created a new Controller so the form can perform a submit and gets a message with information about the summited value.

### JS UI Component
This task was accomplished by overriding the minicart Block, at the jsLayout section and changing the minicart item.renderer component, this way it uses a new html item element.
Then adding a Plugin to include the new attribute value to the item cart information. Now the minicart shows the new attribute value just under the product name.  
