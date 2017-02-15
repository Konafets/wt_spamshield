

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


Set up scheduler task
^^^^^^^^^^^^^^^^^^^^^

You can run a scheduler task to clean up old logs created by
wt\_spamshield. Just create a new task and choose the following
settings:

- Class: "Table garbage collection"

- Type: "Recurring"

- Table to clean up: "tx\_wtspamshield\_log"

- Delete entries older than given number of days: 180 (default) or 90
  or whatever you want

Make sure your TPYO3 installation is configured properly to run
scheduler tasks.