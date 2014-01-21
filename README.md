PHP based web deployment tool, I originally wrote this portal to aid Red Hat Server and workstation deployment and inventory.
Deployment was completed  using complex kickstart scripts.

The original design allowed multiple sites to have their own inventory, used a corporate LDAP for authentication and LDAP groups for delegation.

System work flow was:
1. Add a machine to the inventory
-- give it a hostname
-- give it the allocated IP address
-- specify the mac address
-- suggest the user (ldap and Display name)
-- select the given hardware - this is a prepopulated mysql table, work was in progress to add a gui to add/remove hardware.
-- a suggested kickstart config is given, but can also be selected.
-- validation occurs
-- enable for deployment
-- machine added - this part a pxelinux config script is copied to the relevant location based upon the above config.
2. Deploy workstation
-- preconfigured PXE install environment required 
-- machine boots over network loads its config file and preliminary checks happen (present in inventory, eligible for deployment)
-- if all present and correct, machine runs through it's kickstart script.
2.4 at the end of the kickstart/install a signal is sent back to the server and the "eligible for deployment" field is marked NULL



