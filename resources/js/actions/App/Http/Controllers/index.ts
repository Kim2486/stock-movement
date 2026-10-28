import ProductController from './ProductController'
import HistoryController from './HistoryController'
import EmployeeController from './EmployeeController'
import Settings from './Settings'
const Controllers = {
    ProductController: Object.assign(ProductController, ProductController),
HistoryController: Object.assign(HistoryController, HistoryController),
EmployeeController: Object.assign(EmployeeController, EmployeeController),
Settings: Object.assign(Settings, Settings),
}

export default Controllers