.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _tutorial-create-ratingobjects:

Creating ratingobjects
======================

Before a rating could be done at least one ratingobject must be created and configured with ratingsteps.

Open your configured storage page in list view
(see constant :ref:`plugin.tx_thrating.settings.pluginStoragePid <ts-constants>`)

Add a new record of type ``ratingobjects``.

|BE_RatingObjects.png|

|BE_createRatingObjects.png|

Ratingobjects will be created automatically (see :ts:`pluginStoragePid` at :ref:`ts-constants`)
when doing the first rating of an object. Finally create your ratingsteps.
Normal ratings require a ratingtep weight of value ``1``. This means all steps are rated equal.
``Ratingstep name`` could be given a value of your choice.

|BE_createRatingSteps.png|

You may also set a speaking text (Ratingstep name) for your ratingstep.
In multilanguage sites you could also configure language specific ratingstep names.
If you want to do so please add the wanted site language to the storage page.

|BE_createRatingStepname.png|


.. ==================================================
.. Image definitions
.. --------------------------------------------------

.. |BE_RatingObjects.png|           image:: Images/BE_RatingObjects.png
   :alt: Ratingobjects
   :align: top
   :width: 650
.. |BE_createRatingObjects.png|     image:: Images/BE_createRatingObjects.png
   :alt: Create ratingobjects
   :align: top
   :width: 465
.. |BE_createRatingSteps.png|       image:: Images/BE_createRatingSteps.png
   :alt: Create ratingsteps
   :align: top
   :width: 465
.. |BE_createRatingStepname.png|    image:: Images/BE_createRatingStepname.png
   :alt: Create stepnames
   :align: top
   :width: 465
