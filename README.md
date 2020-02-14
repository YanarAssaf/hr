<p align="center">HR | Login</p>


## About HR App

HR is a web application | Leave Management System.

You may manage and approve employee leave applications/ PTO from a very intuitive user interface. All employee Historical Leave records and current Leave Entitlements are readily accessible.

Feathers:
- Leave System(reqest, pending, accept, reject)
- Employee System(employee, department, balance)

## Clone

- git clone https://github.com/YanarAssaf/hr
- update .env.prod
- docker-compose up -d --build
- docker-compose exec app php /var/www/artisan migrate:fresh --seed
- Login | user:admin@hr.sy password:12345678

## Contacts

If you discover a security vulnerability within App, please send an e-mail to Yanar Assaf via [yanar@outlook.com](mailto:yanar@outlook.com).

## License

This app is open-sourced .