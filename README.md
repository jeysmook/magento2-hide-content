## Introduction
**HideContent** is an extension for Magento 2 ecosystem, which will allow You to hide the necessary HTML content.
## Requirements
 - Magento CE 2.2.1+
 - PHP 7.0.22+
## Install HideContent
1. Installation via packagist 
    - ```composer require jeysmook/magento2-hide-content```
2. Execute commands
    - ```php bin/magento setup:upgrade```
    - ```php bin/magento setup:di:compile```
    - ```php bin/magento cache:flush``` or ```php bin/magento cache:clean```
## Usage
Let's say you have a unit that you want to hide for non logged user, all you need to do is to wrap this block in a special token.
```
<?php echo $block->getHtmlOpenToken(\Jeysmook\HideContent\Model\Token\CustomerLogout::TOKEN_NAME); ?>
<div class="only-customer-is-logged-in">
    <form action="<?php /* @NoEscape */ $block->getSubmitUrl() ?>" method="post">
        ...
    </form>
</div>
<?php echo $block->getHtmlCloseToken(\Jeysmook\HideContent\Model\Token\CustomerLogout::TOKEN_NAME); ?>
```
