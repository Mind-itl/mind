# Objects


## Login
`string`

## User
```
{
	"login": Login,
	"names": {
		"given": string, "father": string, "family": string
	},
	"is_student": bool,
	"roles": Role[] | null,
	"role_args": string[Role] | null,
	"points": int | null,
	"group": {
		"par": int,
		"lit": string
	} | null
}
```

## Role
```
enum {
	"student", "teacher", "diric", "classruk", "vospit", "zam", "admin", "predmet"
}
```

## Cause
`string`

String code that determines the cause of adding points, for example `C1`, `A2`

## Transaction
```
{
	"time": string,
	"from_login": Login,
	"to_login": Login,
	"points": int,
	"cause": Cause
}
```

# Methods

## getUser
**arguments**: `login: Login`,
**return**: `User`
