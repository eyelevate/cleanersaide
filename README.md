blackball known bugs list
=========

Black Ball Ferry Line - Reservation CMS
/********* GENERAL ***********/
[11/29/2012]
- DONE - Edit pages. Change "Edit" to "Save Changes" or "Save"
- DONE - Make datepicker select on first pick and auto close.
- DONE - Foreign Exchange Section needs to be built
- DONE - Tax Rate needs to be its own section
- DONE - Locations in its own section and refer to them in hotels / attractions

/********** Exchange rate */
- DONE - table (net, exchange, gross, flag) - use flag if the gross has been rounded

- I - Exchange rate edit page needs a to warning you are changing, show old and new rate effects. 
- I - green if changed exchange rate.
- I - red if set price.  

/********  FERRIES **********/
[10/30/2012] 
- DONE - An issue where schedules being saved is over a 3 month period, is not being fully saved. check server for maxtime
[10/30/2012] 
- DONE - An issue where Not in service is allowed where a current date is taken. [schedules/add]
- DONE - Finish working ferry schedule edit page
 
[11/29/2012]
- DONE - Setup towed unit descriptions and associations of those descriptions with the appropriate vehicle type
- DONE - Extra Footage pricing/ handling functionality still pending
- DONE - When clicking "View" on an inventory item, get a page full of errors
- DONE - Edit/delete schedule utility doesnt work, 
- DONE - "Edit Schedule, Delete, Cancel Edit" does nothing. 
- DONE - Selecting date range to edit, calendar goes to bottom of screen. Annoyed by it. 
- DONE - Reservation Fee Setup
- DONE - datepicker errors
- DONE - view ferries edit not clickable link
- DONE - add ferry inventory - errors
- DONE - inc units footage, 18 feet, then add inc units. not the other way around

[12/26/2012]
- DONE - fix ferry schedule delete table error
- DONE - fix ferry schedule change trip dynamics on top of the page to reflect exact trips. not 1-10, but count the trips and set the option field with the exact trip count.
- DONE - finish schedule edit individual day. 

[1/13/2012]
- DONE - Ferry Schedule, not saving after 3 months of saving. Need to make a "please wait" script that sends a portion of the data via ajax, and have the form save the rest upon completion. 
- - Double check that duplicate times are not saving on the same date. There was a scenario where after saving 3 months of data, one date and time was duplicated.
- - David wants Inventory Type specific tabs on calendar. This is possible, however this is script that will require me to rewrite the model to show only inventory types data, which will take me some time.


/******** HOTELS ***********/
[11/19/2012]
- DONE - drop down hotel location
- DONE - name and location above wizard as header
- DONE - prefill state, city, country from location
- DONE - underneath hotel website place reservation email.
- DONE - hotel block rates -comment out
- DONE - clone extra person rate, tax rate rates on room  (add room inventory)
- DONE - markup % inbtwn net and gross rate, back and forth btwn gross and net.
- DONE - hotel settings, default hotel rate
- DONE - add room inventory -> add new schedule
- DONE - Room Blackout Dates on a per room basis, calendar by years, smart dates (taken dates), select multiple dates
- DONE - hotel details -> hotel add-ons [new section], creatable list, create pricing, disable on per room basis (check list checked by default). is this a one time ora per night fee
- DONE - hotel room -> hotel type -> hotel name
- DONE -  hotel preview -> remove [available] with 3/8

- DONE - Tax UI - select options, multi select
- DONE - get rid of tax rate box, exchange rate
- DONE - net rate in canadian , gross rate in usd
- DONE - net rate (default can, option to us and can), exchange, markup rate, gross rate

[11/27/2012]
- DONE - Draft status from "Basic Info", needs to be set before moving on to stage 2 of creation. Thinking about using "In Process"
- I - Test out hotel calendar schedule, are dates completely displaying properly? seems like the end day is missing on some. need to run tests
- I - Hotel Edit page, need to be able to see pictures as well as delete them from the fields, and add more if necessary
- DONE - Hotel Edit Page, having an issue where hotel rooms are creating a new data entry instead of editing the current id. 
- DONE - price format on base prices

[11/29/2012]
- DONE - Hotels -> admin page. Clicking delete does nothing
- DONE - change DMT to DMF.

[12/26/2012]
- I - exchange rate on hotels event based on location. have 2 form types either us or can
[1/13/2012]
- DONE - Make reservation email an optional field
- DONE - Change "Billing Address" to "Mailing Address"
- DONE - Make calendar icon image open up the calendar
- DONE - Blackout date calendar closes on click. Make it stay open until finished choosing all the dates.
- DONE - Add Hotel Room does not work on edit page if no previous existing rooms were created on add page. 
- DONE - Recieved a max_time_out error on hotel save. Need to test out server time outs. Maybe extend it for large amounts of data being saved.


/********** ATTRACTIONS *************/
[11/29/2012]
- DONE - Attractions actions on admin page do nothing.
- DONE - Clicking on the button to see the next page of listings gives an error "theres no such page"
- DONE - Time table to attraction tickets
- DONE - Time Table add page, canadian form non time table is not switching exchange rates properly

- DONE - Deleting a time deletes all of the rows. Deletes every time. 
- DONE - Time cloning based on time
[1/13/2012]

- DONE - Make reservation email an optional field
- DONE - Change "Billing Address" to "Mailing Address"
- DONE - Make calendar icon image open up the calendar
- DONE - Blackout date calendar closes on click. Make it stay open until finished choosing all the dates.
- - Finish ticket schedule on edit page

/******** PACKAGES *************/


Johns Notes
- DONE - Menu : Get rid of View Ferries everything. 
- DONE - Wizard: Tabs will be better. Get rid of wizard. Step 1 - 4 will need to be tabs.
- DONE - prompt to are you sure you want to remove?
- tab 1: incremental units
- tab 2: 

/***
 * Monday to do list
 */

- make sure that cronjob is working properly
- finish off price adjustment
- finish off 


