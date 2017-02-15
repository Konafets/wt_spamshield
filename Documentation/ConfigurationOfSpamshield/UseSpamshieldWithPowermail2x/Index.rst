

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


Use wt\_spamshield with powermail 2.x
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

powermail 2.x comes with a built-in spamshield. This spamshield is
quite good but does not have an Akismet or blacklist check.


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.powermail2 = 1


Add TypoScript Setup
""""""""""""""""""""

::

   plugin.wt_spamshield {
     # configure Akismet
     fields {
       powermail2 {
         author = 1
         email = 2
         homepage = 3
         body = 5
       }
     }
   }


TypoScript explanation
""""""""""""""""""""""

With the setting in the constants you can enable or disable the plugin
on different pages.

With the settings in the setup you can configure Akismet. **You have
to** define the powermail fields which represent the author name,
email address, an URL (if necessary) and a message field.In contrast
to powermail 1.x you have to supply only integer values to identify
the fields. You must not enter the prefix "uid".