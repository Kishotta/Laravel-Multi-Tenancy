# Laravel Multi Tenancy

This repo demonstrates how multi-tenancy may be achieved with multiple tenant types.

## Demonstration

### Database Setup

This project includes seeders for populating 5 tenants for each of the 2 different tenant types `Contractor`s and `Operator`s. Run the database migrations and seeders with `php artisan migrate:fresh --seed`.

The application also utilizes a `TenantUser` class to allow a single `User`to be associated with multiple `Tenant`s. These models and their relationships are not present in the seeders and will need to be created manualy. To do so, run the following commands in a terminal window at the project directory:

1. `php artisan tinker`
2. `$user = User::factory()->create()`
3. `$user->tenants()->attach(Contractor::first())`
4. `$user->tenants()->attach(Operator::first())`

The single user in the system will not be associated with the first contractor and first operator.

### Accessing the dashboard

Start by attempting to navigate the "dashboard" page at `/home`. The page should 404 since the dashboard is gated to a logged-in tenant, and no tenant is logged in.

Navigate to `/login/1` to log in as the first `TenantUser` (the one associated with the first `Contractor`). Afterwards, when navigating to `/home`, the name of the tenant should be displayed along with the tenant's type.

You can access another tenant's dashboard by including their slug in the url. Look at the generated `Contractor` and `Operator` records. Include their slugs in the dashboard url (`/contractor-or-operator/home`) to see the dashboard for that tenant.

There aren't currently any permissions linked up, so any user, logged in or not, can view any tenant's info by including the tenant slug in the url.

### Contractor Specific Page

`Contractor` tenants have a `/roster`route exposed that currently `dd`s the contractor who's data we would like to access. You should be able to view dumped data at `/roster` since the first `TenantUser` is associated with a contractor. You can also visit `/contractor-slug/roster` to view the "roster pages" of other contractors. Note that attepmting to visit the roster page with an `Operator` tenant slug results in a 404.

### Operator Sepcific PAge

`Operator` tenants have a `/config` route exposed that behaves identically to the contractor `/roster` page, but `dd`ing the operator object instead. You can visit `/login/2` to switch to the second `TenantUser`, which should be associated with an operator, to view this page. 

## How It Works

For "current" tenant pages, there are 2 types of middlewares that work together to gate access to a page:

1. `RetrieveTenantContextFromSession`

As the name implies, this middleware looks at the `tenant_user_id` session variable and fetches the relevant `TenantUser`. It then tells Laravel's dependency injection resolver to inject the associated tenant: `app()->instance(Tenant::class, $tenantUser->tenant);`

2. `ContractorOnly`, `OperatorOnly`, etc.

These middlewares accept a `Tenant` and abort the request with a 404 if the resolved tenant's type is incorrect. Routes with these middlewares should *only* be visible to or for tenants of that type. Note that the `Tenant` injected into these middlewares is directed by the previously mentioned middleware. As such, it's important that all the afformentioned middlewares be processed in the appropriate order.

For "other" tenant pages, we can utilize Laravel's built-in Route Model Binding. If a `Contractor` tenant slug is entered for a route who's controller expects an `Operator`instance, then the binding will fail to find the appropriate
