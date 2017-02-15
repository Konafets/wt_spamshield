.. include:: Images.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Use wt\_spamshield with ve\_guestbook
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Add a new page
""""""""""""""

Create a new page (maybe hidden in the navigation) and enter a text
which should be shown if spam was recognized.

|img-10|


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.ve_guestbook = 1
   plugin.wt_spamshield.redirect_ve_guestbook = 17


TypoScript explanation
""""""""""""""""""""""

With the first line you can enable or disable the plugin on different
pages.

With the second line you define where the user will be redirected if
spam was recognized. Enter a PID only!