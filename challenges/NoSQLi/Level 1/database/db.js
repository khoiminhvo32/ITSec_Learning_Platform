db = new Mongo().getDB("hpt");

db.createCollection('users', { capped: false });

db.users.insert([
    { username: "admin", password: "HPT{babi_sqli_but_in_form!!!!!!}" },
    { username: "phuong", password: "f28520e0f03cff422ee45d69904d79cc" },
    { username: "lan", password: "e5c43d2718f2a1e7b6bf9839bd274ec5" },
    { username: "vu", password: "d3920c990edb0ebc7da441426b882732" }
]);