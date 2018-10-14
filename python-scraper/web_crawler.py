from urllib import request
from bs4 import BeautifulSoup
import re
import json
import datetime

months = {"01": "January", "02": "February", "03": "March", "04": "April", "05": "May", "06": "June", "07": "July", "08": "August", "09": "September", "10": "October", "11": "November", "12": "December"}

class web_menu(object):
    # class of web menus
    date = ""
    url = ""
    data = bytes()
    soup = BeautifulSoup(features="lxml")
    meals = []
    diningHalls = []
    bars = []
    dishes = []
    tags = []
    jsonOutput = []

    def __init__(self, date):
        # instantiation
        self.date = date
        date_ = date.split('-')
        self.url = urlib.parser.quote("https://hospitality.usc.edu/residential-dining-menus/?menu_date=" + months[date_[1]] + "+" + date_[2].lstrip('0') + "%2C" + "+" + date_[0])
        print(self.url)
        with request.urlopen(self.url) as menus:
            self.data = menus.read()
            print('Status:', menus.status, menus.reason)
            for k, v in menus.getheaders():
                print('%s: %s' % (k, v))
        self.soup = BeautifulSoup(self.data.decode('utf-8'),'html.parser')

        # search for separate html category
        meals_ = self.soup.find_all(class_="hsp-accordian-container")
        diningHalls_ = []
        bars_ = []
        for i_meal in range(len(meals_)):
            diningHalls_.append(meals_[i_meal].find_all(class_="col-sm-6 col-md-4"))
            bars_.append([])
            for i_diningHall in range(len(diningHalls_[i_meal])):
                if diningHalls_[i_meal][i_diningHall].find(class_="menu-item-list"):
                    bars_[i_meal].append(diningHalls_[i_meal][i_diningHall].find_all(class_="menu-item-list"))
                else:
                    bars_[i_meal].append([])

        # # write the filtered html in filtered.txt [DEBUG]
        # with open("filtered.txt", "w") as newFile:
        #     for meal in meals_:
        #         newFile.write(str(meal) + '\n')
        #         for diningHall in diningHalls_[meals_.index(meal)]:
        #             newFile.write('\t' + str(diningHall) + '\n')
        #             if diningHalls_[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)].find(class_="menu-item-list"):
        #                 for bar in bars_[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)]:
        #                     newFile.write('\t\t' + str(bar) + '\n')
        #             else:
        #                 newFile.write('\t\t' + 'Null' + '\n')

        # search for separate dish tags
        self.dishes = []
        for meal in meals_:
            self.dishes.append([])
            for diningHall in diningHalls_[meals_.index(meal)]:
                if diningHall.find(class_="menu-item-list"):
                    self.dishes[meals_.index(meal)].append([])
                    for bar in bars_[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)]:
                        self.dishes[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)].append(bar.find_all("li"))
        
        #search for separate type tags
        self.tags = []
        for meal in meals_:
            self.tags.append([])
            for diningHall in diningHalls_[meals_.index(meal)]:
                if diningHall.find(class_="menu-item-list"):
                    self.tags[meals_.index(meal)].append([])
                    for bar in bars_[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)]:
                        self.tags[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)].append([])
                        for dish in self.dishes[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)][bars_[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)].index(bar)]:
                            self.tags[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)][bars_[meals_.index(meal)][diningHalls_[meals_.index(meal)].index(diningHall)].index(bar)].append(dish.find_all("i"))

        # search for separate bar tags
        self.bars = []
        for meal in meals_:
            self.bars.append([])
            for diningHall in diningHalls_[meals_.index(meal)]:
                if (diningHall.find(class_="menu-item-list")):         
                    self.bars[meals_.index(meal)].append(diningHall.find_all("h4"))
                else:
                    self.bars[meals_.index(meal)].append("Null")

        # search for separate diningHall tags
        self.diningHalls = []
        for meal in meals_:
            self.diningHalls.append(meal.find_all(class_="menu-venue-title"))

        # search for separate meal tags
        self.meal = []
        self.meals = self.soup.find_all(class_="fw-accordion-title-inner")

    
    def print_rawhtml(self):
        # print raw html file in console
        print('Data:', self.data.decode('utf-8'))

    
    def raw_output_txt(self, fileName="output.txt"):
        # write output in txt file
        with open(fileName, "w") as newFile:
            newFile.write(self.data.decode('utf-8'))


    def filtered_output_txt(self, fileName="filtered.txt"):
        # write the filtered menu in filtered.txt
        with open("filtered.txt", "w") as newFile:
            for meal in self.meals:
                newFile.write(meal.get_text().split()[0] + '\n')
                for diningHall in self.diningHalls[self.meals.index(meal)]:
                    newFile.write('\t' + diningHall.get_text() + '\n')
                    if (type(self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)]) == type(self.meals)):
                        for bar in self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)]:
                            newFile.write('\t\t' + bar.get_text() + '\n')
                            for dish in self.dishes[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)][self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)].index(bar)]:
                                newFile.write('\t\t\t' + str(dish)[4: re.compile(r"(?<=<li>)[^<]+(?=<span)").search(str(dish)).end()] + '\n')
                                for tag in self.tags[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)][self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)].index(bar)][self.dishes[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)][self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)].index(bar)].index(dish)]:
                                    newFile.write('\t\t\t\t' + tag.span.get_text() + '\n')
                    else:
                        newFile.write('\t\t' + self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)] + '\n')
    
    def filtered_output_json_convert(self):
        #write the filtered menu in json fotrmat
        self.jsonOutput = []
        for diningHall in self.diningHalls[0]:
            self.jsonOutput.append({"dining hall": diningHall.get_text()})
            self.jsonOutput[self.diningHalls[0].index(diningHall)]["date"] = self.date
            for meal in self.meals:
                self.jsonOutput[self.diningHalls[self.meals.index(meal)].index(diningHall)][meal.get_text().split()[0]] = []
                if (type(self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)]) == type(self.meals)):
                    index = 0
                    for bar in self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)]:
                        for dish in self.dishes[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)][self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)].index(bar)]:
                            self.jsonOutput[self.diningHalls[self.meals.index(meal)].index(diningHall)][meal.get_text().split()[0]].append({"name": str(dish)[4: re.compile(r"(?<=<li>)[^<]+(?=<span)").search(str(dish)).end()]})
                            self.jsonOutput[self.diningHalls[self.meals.index(meal)].index(diningHall)][meal.get_text().split()[0]][index]["type"] = []
                            for tag in self.tags[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)][self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)].index(bar)][self.dishes[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)][self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)].index(bar)].index(dish)]:
                                self.jsonOutput[self.diningHalls[self.meals.index(meal)].index(diningHall)][meal.get_text().split()[0]][index]["type"].append(tag.span.get_text())
                            index += 1

    def filtered_output_json(self, fileName="../content.json"):
        with open(fileName, "w") as newFile:
            newFile.write(json.dumps({self.date: self.jsonOutput}))

class double_week_web_menu(object):
    dates = []
    webMenus = []
    jsonOutput_ = {}
    
    def __init__(self):
        for i in range(3):
            self.dates.append((datetime.date.today() + datetime.timedelta(i)).isoformat())
            self.webMenus.append(web_menu(self.dates[i]))
    
    def filtered_output_json(self, fileName="../contents.json"):
        for i in range(3):
            self.webMenus[i].filtered_output_json_convert()
            self.jsonOutput_[self.dates[i]] = self.webMenus[i].jsonOutput
        with open(fileName, "w") as newFile:
            newFile.write(json.dumps(self.jsonOutput_))
        
            



menus = double_week_web_menu()
menus.filtered_output_json()