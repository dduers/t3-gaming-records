..  include:: /Includes.rst.txt

..  _installation:

============
Installation
============

This extension is hosted on packagist.

..  contents:: Table of contents
    :local:

..  _installation-composer:

Installation with Composer
==========================

Check whether you are already using the extension with:

..  code-block:: bash

    composer show | grep t3-gaming-records

This should either give you no result or something similar to:

..  code-block:: none

    dduers/t3-gaming-records       v1.0.0

If it is not installed yet, use the ``composer require`` command to install
the extension:

..  code-block:: bash

    composer require dduers/t3-gaming-records

The given version depends on the version of the TYPO3 Core you are using.
