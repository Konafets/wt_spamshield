

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


Use wt\_spamshield with comments
^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.comments = 1


TypoScript explanation
""""""""""""""""""""""

With the setting in the constants you can enable or disable the plugin
on different pages.

Normally, you don't have to configure anything else. Akismet
integrates automatically. Nonetheless, it is possible to enter other
names of the form fields in order to configure wt\_spamshield/
Akismet for comments.