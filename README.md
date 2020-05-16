# URL SHORTENER API


    git clone https://github.com/wjjunior/url-shortner.git
    cd url-shortner
    docker-compose up -d
    docker-compose exec app composer install
    cp .env.example .env
    docker-compose exec app php artisan key:generate

Endpoint: [http://localhost/graphql](http://localhost/graphql-playground)

Tests: `docker-compose exec app composer run test`
# Querys
#### FIELDS

urls(first: Int = 10, page: Int): UrlPaginator
Arguments
first: Int	
Limits number of fetched elements.

page: Int	
The offset from which elements are returned.

url(id: ID): Url
# Mutations
####  FIELDS
createUrl(input: UrlInput!): Url

# UrlPaginator
A paginated list of Url items.

####  FIELDS
paginatorInfo: PaginatorInfo!
Pagination information about the list of items.

data: [Url!]!
A list of Url items.

# Url
####  FIELDS
id: ID!
link: String!
shortlink: String!
created_at: DateTime!
updated_at: DateTime!
# UrlInput
#### FIELDS
link: String!
short: String
# PaginatorInfo
Pagination information about the corresponding list of items.

#### FIELDS
count: Int!
Total count of available items in the page.

currentPage: Int!
Current pagination page.

firstItem: Int
Index of first item in the current page.

hasMorePages: Boolean!
If collection has more pages.

lastItem: Int
Index of last item in the current page.

lastPage: Int!
Last page number of the collection.

perPage: Int!
Number of items per page in the collection.

total: Int!
Total items available in the collection.
