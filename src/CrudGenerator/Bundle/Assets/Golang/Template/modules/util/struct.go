package util

import (
	"reflect"
	"strings"
)

// BindStruct ...
func BindStruct(to, from interface{}) {

	toStruct := reflect.ValueOf(to).Elem()
	fromStruct := reflect.ValueOf(from)
	typeOfFrom := fromStruct.Type()
	for i := 0; i < fromStruct.NumField(); i++ {

		name := typeOfFrom.Field(i).Name
		fieldFrom := fromStruct.Field(i)

		fieldTo := toStruct.FieldByName(name)
		if fieldTo.IsValid() {
			fieldTo.Set(fieldFrom)
		}
	}

}

// DiffStruct ...
func DiffStruct(from, to interface{}) map[string]interface{} {

	data := map[string]interface{}{}

	toStruct := reflect.ValueOf(to)

	fromStruct := reflect.ValueOf(from).Elem()
	typeOfFrom := fromStruct.Type()
	for i := 0; i < fromStruct.NumField(); i++ {

		name := typeOfFrom.Field(i).Name
		fieldFrom := fromStruct.Field(i)
		valueFrom := fieldFrom.Interface()

		fieldTo := toStruct.FieldByName(name)
		if !fieldTo.IsValid() {
			continue
		}

		valueTo := fieldTo.Interface()
		if valueFrom != valueTo {
			settings := parseTagSetting(typeOfFrom.Field(i).Tag)
			column := settings["COLUMN"]
			if column != "" {
				data[column] = valueTo
				fieldFrom.Set(fieldTo)
			}
		}

	}

	return data
}

func parseTagSetting(tags reflect.StructTag) map[string]string {
	setting := map[string]string{}
	for _, str := range []string{tags.Get("sql"), tags.Get("gorm")} {
		tags := strings.Split(str, ";")
		for _, value := range tags {
			v := strings.Split(value, ":")
			k := strings.TrimSpace(strings.ToUpper(v[0]))
			if len(v) >= 2 {
				setting[k] = strings.Join(v[1:], ":")
			} else {
				setting[k] = k
			}
		}
	}
	return setting
}
