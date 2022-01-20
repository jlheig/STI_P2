# STI Project - Insecure email service

## Install and run the project locally

### Install 

Clone the project
```bash
$ git clone git@github.com:kayoumido/STI_P1.git sti_project
```

Then run the install script
```bash
$ ./docker/install.sh
```

### Run
Start the container(s)
```bash
$ docker-compose up -d
```

#### Available users

| User  | Password | Role     | Active |
| ----- | -------- | -------- | ------ |
| Admin | root     | admin    | yes    |
| Jin   | 1234     | employee | yes    |
| Erso  | 4321     | employee | no     |

