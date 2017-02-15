

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


Use wt\_spamshield with ke\_userregister
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.ke_userregister = 1


TypoScript explanation
""""""""""""""""""""""

With the setting in the constants you can enable or disable the plugin
on different pages.


Further settings
""""""""""""""""

To show an error message (in case of detecting spam) above all form
fields you have to create a custom field via TypoScript and add it to
your ke\_userregister HTML template. wt\_spamshield ships with a
default TypoScript setup for ke\_userregister (you don't have to add
this to your own TypoScript template):

::

   plugin.tx_keuserregister {
     create.fields {
       # create field for error messages
       wt_spamshield {    
         type = text
         doNotSaveInDB = 1
       }
     }
   }

Create a copy of the ke\_userregister HTML template and add a marker
###ERROR\_WT\_SPAMSHIELD### to the subpart <!-- ###REGISTRATION\_FORM### start -->