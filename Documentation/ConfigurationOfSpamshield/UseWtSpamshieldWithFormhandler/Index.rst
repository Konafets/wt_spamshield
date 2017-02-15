

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


Use wt\_spamshield with formhandler
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Since the code has been ported form the extension wt\_spamshield\_formhandler
the manual provided by this extension is still valid. We will adopt the
documentation as soon as possible. For now please check `http://docs.typo3.org/typo3cms/extensions/wt_spamshield_formhandler/ <http://http://docs.typo3.org/typo3cms/extensions/wt_spamshield_formhandler//>`_.

Add static template
"""""""""""""""""""

In addition to wt\_spamshield\_formhandler the wt\_spamshield
extension ships with a honeypot.

Add the static template "formhandler (wt\_spamshield)". This will
set up a new marker ( "HONEYPOT" ) which has to be added to your
formhandler template.


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.formhandler = 1


TypoScript explanation
""""""""""""""""""""""

With the setting in the constants you can enable or disable the plugin
on different pages.