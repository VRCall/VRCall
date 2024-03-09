# VRCall

## Setup du projet

### Front
```sh
cd client
npm install
npm run dev
```

### Back

Ajouter l'adresse du frontend dans la variable `FRONTEND_BASE_URL` du fichier .env

Ajouter le port dans la variable `PORT` du fichier .env (optionnel)

```sh
cd server
npm install
npm run dev
```

### Base de données

Ajouter la connection string vers votre base de données dans la variable `DATABASE_URL` du fichier .env

`npx prisma db push` pour synchroniser la base de données

`npx prisma studio` pour accéder à l'interface de prisma à l'adresse http://localhost:5555