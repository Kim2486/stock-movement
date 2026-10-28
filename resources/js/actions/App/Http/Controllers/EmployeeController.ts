import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\EmployeeController::index
 * @see app/Http/Controllers/EmployeeController.php:11
 * @route '/employees'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/employees',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\EmployeeController::index
 * @see app/Http/Controllers/EmployeeController.php:11
 * @route '/employees'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\EmployeeController::index
 * @see app/Http/Controllers/EmployeeController.php:11
 * @route '/employees'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\EmployeeController::index
 * @see app/Http/Controllers/EmployeeController.php:11
 * @route '/employees'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\EmployeeController::syncFromKintone
 * @see app/Http/Controllers/EmployeeController.php:67
 * @route '/employees/sync-kintone'
 */
export const syncFromKintone = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: syncFromKintone.url(options),
    method: 'get',
})

syncFromKintone.definition = {
    methods: ["get","head"],
    url: '/employees/sync-kintone',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\EmployeeController::syncFromKintone
 * @see app/Http/Controllers/EmployeeController.php:67
 * @route '/employees/sync-kintone'
 */
syncFromKintone.url = (options?: RouteQueryOptions) => {
    return syncFromKintone.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\EmployeeController::syncFromKintone
 * @see app/Http/Controllers/EmployeeController.php:67
 * @route '/employees/sync-kintone'
 */
syncFromKintone.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: syncFromKintone.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\EmployeeController::syncFromKintone
 * @see app/Http/Controllers/EmployeeController.php:67
 * @route '/employees/sync-kintone'
 */
syncFromKintone.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: syncFromKintone.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\EmployeeController::bulkDelete
 * @see app/Http/Controllers/EmployeeController.php:57
 * @route '/employees/bulk-delete'
 */
export const bulkDelete = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.definition = {
    methods: ["post"],
    url: '/employees/bulk-delete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\EmployeeController::bulkDelete
 * @see app/Http/Controllers/EmployeeController.php:57
 * @route '/employees/bulk-delete'
 */
bulkDelete.url = (options?: RouteQueryOptions) => {
    return bulkDelete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\EmployeeController::bulkDelete
 * @see app/Http/Controllers/EmployeeController.php:57
 * @route '/employees/bulk-delete'
 */
bulkDelete.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\EmployeeController::edit
 * @see app/Http/Controllers/EmployeeController.php:27
 * @route '/employees/{id}/edit'
 */
export const edit = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/employees/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\EmployeeController::edit
 * @see app/Http/Controllers/EmployeeController.php:27
 * @route '/employees/{id}/edit'
 */
edit.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return edit.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\EmployeeController::edit
 * @see app/Http/Controllers/EmployeeController.php:27
 * @route '/employees/{id}/edit'
 */
edit.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\EmployeeController::edit
 * @see app/Http/Controllers/EmployeeController.php:27
 * @route '/employees/{id}/edit'
 */
edit.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\EmployeeController::update
 * @see app/Http/Controllers/EmployeeController.php:33
 * @route '/employees/{id}'
 */
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/employees/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\EmployeeController::update
 * @see app/Http/Controllers/EmployeeController.php:33
 * @route '/employees/{id}'
 */
update.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return update.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\EmployeeController::update
 * @see app/Http/Controllers/EmployeeController.php:33
 * @route '/employees/{id}'
 */
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\EmployeeController::destroy
 * @see app/Http/Controllers/EmployeeController.php:51
 * @route '/employees/{id}'
 */
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/employees/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\EmployeeController::destroy
 * @see app/Http/Controllers/EmployeeController.php:51
 * @route '/employees/{id}'
 */
destroy.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return destroy.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\EmployeeController::destroy
 * @see app/Http/Controllers/EmployeeController.php:51
 * @route '/employees/{id}'
 */
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const EmployeeController = { index, syncFromKintone, bulkDelete, edit, update, destroy }

export default EmployeeController