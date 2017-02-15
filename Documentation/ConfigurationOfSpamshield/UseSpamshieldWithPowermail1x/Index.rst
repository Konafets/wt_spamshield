

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


Use wt\_spamshield with powermail 1.x
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.powermail = 1


Add TypoScript Setup
""""""""""""""""""""

::

   plugin.wt_spamshield {
     # configure Akismet
     fields {
       powermail {
         author = uid1
         email = uid2
         homepage = uid3
         body = uid5
       }
     }
   }


TypoScript explanation
""""""""""""""""""""""

With the setting in the constants you can enable or disable the plugin
on different pages.

With the settings in the setup you can configure Akismet.  **You have
to** define the powermail fields which represent the author name,
email address, an URL (if necessary) and a message field.