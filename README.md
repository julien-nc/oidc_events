# Oidc events

React to user_oidc token events.

This app depends on [user_oidc](https://github.com/nextcloud/user_oidc).
The "Store login tokens" user_oidc's admin setting must be enabled for this app to work.

user_oidc emits a UserObtainedTokenEvent event when the user logs in Nextcloud and when the login token is refreshed automatically.
This event contains the new login token (fresh or refreshed). The new token is used to set the inbound/outbound password of the first Mail accoun that is found.