<!--  
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⠀⠀⠀⠀⠉⠙⠻⣦⡀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣠⣴⣿⣿⠀⠀⠀⠘⠲⣤⡀⠈⢻⡄⠀⠀
⠀⠀⠀⡄⠀⣴⣶⣶⣶⣶⣶⣾⣿⣿⣿⣿⣿⣿⠀⠀⠀⣦⡀⠈⢻⡄⠈⣿⠀⠀
⠀⠀⠀⡇⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⡇⠀⢸⡷⠀⢸⡷⠀⣿⡇⠀
⠀⠀⠀⠃⠀⠻⠿⠿⠿⠿⠿⢿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠟⠁⢀⣼⠃⢀⣿⠀⠀
⠀⠀⠀⠀⠀⢲⣶⣶⠀⠀⠀⠀⠀⠈⠙⠻⣿⣿⠀⠀⠀⢠⠴⠛⠁⢀⣼⠃⠀⠀
⠀⠀⠀⠀⠀⠘⣿⣿⣆⠀⠀⠀⠀⠀⠀⠀⠀⠙⠀⠀⠀⠀⣀⣠⣴⠟⠁⠀⠀⠀
⠀⠀⠀⠀⠀⠀⢻⣿⣿⣆⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠉⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠘⠛⠛⠛
-->

> [!WARNING]
> DO NOT ADD ANY CA INTO THIS DIRECTORY UNLESS YOU ARE FULLY FAMILIAR WITH THE DEVELOPER/PROVIDER AND UNDERSTAND THE RISKS INVOLVED

> The Open Paging Server Project will NOT provide ANY support via either the OSS community or commercially for issues with modules signed by third parties.
> Nor are we responsible for damage to your system, network, or users caused by malicious plugins and endpoint modules signed by third parties.

> If a plugin or endpoint module is open source, you should always review the code before running it on your server, even if it is signed by Open Paging Server or a trusted third party.

> You should not be adding a CA here unless you are installing a trusted third-party plugin or endpoint module requiring it. The CA should be removed along with it if removing the module.

> PROCEED AT YOUR OWN RISK!!!

## Open Paging Server Root CA
The official root CA for the Open Paging Server project (OpenPagingServerProject.crt) will change from time to time. Software update should update the CA automatically. If it does not update, you can get the current one from https://install.openpagingserver.org/rootca.crt

## Signing Requirement
Open Paging Server always requires a plugin or endpoint module to be signed and trusted in order for it to load. 
For security, there is NO WAY to officially bypass this requirement.
The Open Paging Server Project also will not provide any kind of support for forks or user modified verisons of Open Paging Server.
