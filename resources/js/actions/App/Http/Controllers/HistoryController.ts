import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\HistoryController::index
 * @see app/Http/Controllers/HistoryController.php:13
 * @route '/history'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/history',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\HistoryController::index
 * @see app/Http/Controllers/HistoryController.php:13
 * @route '/history'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\HistoryController::index
 * @see app/Http/Controllers/HistoryController.php:13
 * @route '/history'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\HistoryController::index
 * @see app/Http/Controllers/HistoryController.php:13
 * @route '/history'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\HistoryController::syncFromKintone
 * @see app/Http/Controllers/HistoryController.php:29
 * @route '/history/sync-kintone'
 */
export const syncFromKintone = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: syncFromKintone.url(options),
    method: 'get',
})

syncFromKintone.definition = {
    methods: ["get","head"],
    url: '/history/sync-kintone',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\HistoryController::syncFromKintone
 * @see app/Http/Controllers/HistoryController.php:29
 * @route '/history/sync-kintone'
 */
syncFromKintone.url = (options?: RouteQueryOptions) => {
    return syncFromKintone.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\HistoryController::syncFromKintone
 * @see app/Http/Controllers/HistoryController.php:29
 * @route '/history/sync-kintone'
 */
syncFromKintone.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: syncFromKintone.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\HistoryController::syncFromKintone
 * @see app/Http/Controllers/HistoryController.php:29
 * @route '/history/sync-kintone'
 */
syncFromKintone.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: syncFromKintone.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\HistoryController::bulkDelete
 * @see app/Http/Controllers/HistoryController.php:157
 * @route '/history/bulk-delete'
 */
export const bulkDelete = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.definition = {
    methods: ["post"],
    url: '/history/bulk-delete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\HistoryController::bulkDelete
 * @see app/Http/Controllers/HistoryController.php:157
 * @route '/history/bulk-delete'
 */
bulkDelete.url = (options?: RouteQueryOptions) => {
    return bulkDelete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\HistoryController::bulkDelete
 * @see app/Http/Controllers/HistoryController.php:157
 * @route '/history/bulk-delete'
 */
bulkDelete.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\HistoryController::destroy
 * @see app/Http/Controllers/HistoryController.php:148
 * @route '/history/{id}'
 */
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/history/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\HistoryController::destroy
 * @see app/Http/Controllers/HistoryController.php:148
 * @route '/history/{id}'
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
* @see \App\Http\Controllers\HistoryController::destroy
 * @see app/Http/Controllers/HistoryController.php:148
 * @route '/history/{id}'
 */
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const HistoryController = { index, syncFromKintone, bulkDelete, destroy }

export default HistoryController