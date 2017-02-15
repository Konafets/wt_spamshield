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


Use wt\_spamshield with direct\_mail\_subscription
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Add static template
"""""""""""""""""""

Add the static template "direct\_mail\_subscription (wt\_spamshield)".

|img-9|


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.direct_mail_subscription = 1


Add TypoScript Setup
""""""""""""""""""""

::

   plugin.wt_spamshield.fields.direct_mail_subscription {
     author = last_name
     email = email
     homepage =
     body =
     permalink =
   }


TypoScript explanation
""""""""""""""""""""""

With the setting in the constants you can enable or disable the plugin
on different pages.

Normally, you don't have to configure anything else. Akismet
integrates automatically. Nonetheless, it is possible to enter other
or additional names of the form fields in order to configure
wt\_spamshield / Akismet for direct\_mail\_subscription.