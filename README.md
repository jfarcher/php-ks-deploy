PHP based web deployment tool, I originally wrote this portal to aid Red Hat Server and workstation deployment and inventory.
Deployment was completed  using complex kickstart scripts.

The original design allowed multiple sites to have their own inventory, used a corporate LDAP for authentication and LDAP groups for delegation.

System work flow was:
1. Add a machine to the inventory
1.1 give it a hostname
1.2 give it the allocated IP address
1.3 specify the mac address
1.4 suggest the user (ldap and Display name)
1.5 select the given hardware - this is a prepopulated mysql table, work was in progress to add a gui to add/remove hardware.
1.6 a suggested kickstart config is given, but can also be selected.
1.7 validation occurs
1.8 enable for deployment
1.9 machine added - this part a pxelinux config script is copied to the relevant location based upon the above config.
2. Deploy workstation
2.1 preconfigured PXE install environment required 
2.2 machine boots over network loads its config file and preliminary checks happen (present in inventory, eligible for deployment)
2.3 if all present and correct, machine runs through it's kickstart script.
2.4 at the end of the kickstart/install a signal is sent back to the server and the "eligible for deployment" field is marked NULL



