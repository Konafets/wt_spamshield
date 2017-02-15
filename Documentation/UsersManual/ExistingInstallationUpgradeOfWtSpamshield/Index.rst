

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


Existing installation/ upgrade of wt\_spamshield
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

With version 1.1.0 we have introduced some new fields in the database
(for spam logging). If you are upgrading from an earlier version of
wt\_spamshield < 1.1.0 please make sure to compare the database
fields. In TYPO3 version < 6.0 you can do this inside the extension
manager. In TYPO3 Version >= 6.0 you can uninstall and install the
extension again or open the install tool and run the database compare
tool.

In wt\_spamshield 1.2.0 we have removed the configuration which can be
set within the extension manager. All the settings are now available
via TypoScript. We have built a fallback mechanism which also checks
for configured values done within the extension manager. This fallback
will be removed in future versions.