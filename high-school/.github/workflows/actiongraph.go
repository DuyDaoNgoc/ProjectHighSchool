
package core

import (
    "fmt"
    "reflect"
)

func loadNodes(nodes interface{}) error {
    // Ensure nodes is a map
    if reflect.TypeOf(nodes).Kind() != reflect.Map {
        return fmt.Errorf("nodes is not a map")
    }

    // Rest of the function implementation
    // ...
    return nil
}