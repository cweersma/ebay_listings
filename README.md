# NPC eBay Listings Automation

This repository contains a miniature site structure that presents an interface by
which eBay listings can be generated from data stored in the WooCommerce and NIS databases.

## Installation

* Run the following in the desired site location:

```console
# Clone the repository
git clone https://github.com/cweersma/ebay_listings.git .

# Install dependencies
composer install

# Exclude the configuration file from git update
git update-index --skip-worktree inc/config.php
```

* Edit inc/config.php and provide the necessary information as specified in the comments in this file.
