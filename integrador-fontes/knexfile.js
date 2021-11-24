

module.exports = {
  development: {
    client: "sqlite3",
    connection: {
      database: "middleware",
      user: "root",
      password: "",
    },
  },

  staging: {
    client: "mysql",
    connection: {
      database: "middleware",
      user: "root",
      password: "",
    },
    pool: {
      min: 2,
      max: 10,
    },
    migrations: {
      tableName: "knex_migrations",
    },
  },

  production: {
    client: "postgresql",
    connection: {
      database: "middleware",
      user: "root",
      password: "",
    },
    pool: {
      min: 2,
      max: 10,
    },
    migrations: {
      tableName: "knex_migrations",
    },
  },
};
