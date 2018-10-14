from urllib import request
from bs4 import BeautifulSoup
import re
import json

class web_menu(object):
    # class of web menus
    date = ""
    url = ""
    data = bytes()
    soup = BeautifulSoup(features="lxml")
    meals = []
    diningHalls = []
    bars = []

    def __init__(self, date, url="https://hospitality.usc.edu/residential-dining-menus/"):
        # instantiation
        self.date = date
        self.url = url
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
                    else:
                        newFile.write('\t\t' + self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)] + '\n')
    
    def filtered_output_json(self, fileName="content.json"):
        #write the filtered menu in json fotrmat
        jsonOutput = {self.date : []}
        for diningHall in self.diningHalls[0]:
            jsonOutput[self.date].append({"dining hall": diningHall.get_text()})
            for meal in self.meals:
                jsonOutput[self.date][self.diningHalls[self.meals.index(meal)].index(diningHall)][meal.get_text().split()[0]] = []
                if (type(self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)]) == type(self.meals)):
                    for bar in self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)]:
                        for dish in self.dishes[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)][self.bars[self.meals.index(meal)][self.diningHalls[self.meals.index(meal)].index(diningHall)].index(bar)]:
                            jsonOutput[self.date][self.diningHalls[self.meals.index(meal)].index(diningHall)][meal.get_text().split()[0]].append({"name": str(dish)[4: re.compile(r"(?<=<li>)[^<]+(?=<span)").search(str(dish)).end()]})
        with open("content.json", "w") as newFile:
            newFile.write(json.dumps(jsonOutput))






menu0 = web_menu("2018-10-14")
#menu0.print_rawhtml()
menu0.raw_output_txt()
menu0.filtered_output_txt()
menu0.filtered_output_json()