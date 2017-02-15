

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


Use wt\_spamshield with t3\_blog
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Unfortunately, the extension is not ready for TYPO3 6.x. Therefore we
didn't put a lot of time into implementing all the possible spam
checks. Nonetheless, it is quite a good blogging extension.


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.t3_blog = 1


TypoScript explanation
""""""""""""""""""""""

With the setting in the constants you can enable or disable the plugin
on different pages.